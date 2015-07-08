<?php
require __DIR__.'/../vendor/autoload.php';
/**
 * @RoutePrefix("/admin")
*/

class AdminController extends Base
{
    /**
     * @Route("/addUser", methods = {"POST", "OPTIONS"})
     */
    public function AddUserAction()
    {
        $info = $this->request->getJsonRawBody();
        if(!isset($info->name)||!isset($info->password)||!isset($info->passwordConfirmation)||!isset($info->role))
        {
            $this->response->setJsonContent(['message' => 'No Data!']);
            $this->response->send();
            return;
        }
        $name = $info->name;
        $password = $info->password;
        $passwordConfirmation = $info->passwordConfirmation;
        $role = $info->role;
        $user=User::findFirst([
            'conditions' => 'name=?1',
            'bind' => [1 => $name]
        ]);
        if($user != null)
        {
            $this->response->setJsonContent(['message' => '用户名已存在']);
        }
        elseif($password != $passwordConfirmation)
        {
            $this->response->setJsonContent(['message' => '密码不一致']);
        }
        elseif( $role!='admin' && $role!='dispatcher' && $role!='handler' && $role!='assessor')
        {
            $this->response->setJsonContent(['message' => '角色不存在']);
        }
        else
        {
            try
            {
                $user=new User();
                $user->name = $name;
                $user->password = $password;
                $user->role = $role;
                $user->created_at = round(microtime(true) * 1000);
                $this->response->setJsonContent(['name' => $user->name, 'password' => $user->password, 'role' => $user->role, 'created_at' => $user->created_at]);
                $user->save();
            }
            catch(Exception $e)
            {
                $this->response->setJsonContent(['message' => $e->getMessage()]);
            }
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getEmailConf", methods = {"GET", "OPTIONS"})
     */
    public function GetEmailConfAction()
    {
        try
        {
            $filePath = __DIR__.'/../config/email.json';
            $jsonString = file_get_contents($filePath);
            $jsonObj = json_decode($jsonString);
            $this->response->setJsonContent($jsonObj);
        }
        catch(Exception $e)
        {
            $this->response->setJsonContent(['message' => $e->getMessage()]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/confEmail", methods = {"PUT", "OPTIONS"})
     */
    public function ConfEmailAction()
    {
        $info = $this->request->getJsonRawBody();
        if(isset($info->email_address)) $email_address = $info->email_address;
        if(isset($info->imap_address)) $imap_address = $info->imap_address;
        if(isset($info->password))
        {
            $password = $info->password;
            $passwordConfirmation = $info->passwordConfirmation;
            if($password != $passwordConfirmation)
            {
                $this->response->setJsonContent(['message' => '两次密码不一致']);
                $this->response->send();
                return;
            }
        }
        if(isset($info->compay_name)) $company_name = $info->company_name;
        $updated_at = round(microtime(true) * 1000);
        try
        {
            $mailbox = new PhpImap\Mailbox("{{$imap_address}:993/imap/ssl}INBOX", $email_address, $password);
            $mailbox->searchMailbox('ALL');
            $filePath = __DIR__.'/../config/email.json';
            $data = "{\"email_address\": \"{$email_address}\", \"imap_address\": \"{$imap_address}\", \"password\": \"{$password}\", \"updated_at\": \"{$updated_at}\"}";
            file_put_contents($filePath, $data);
            $this->response->setJsonContent(['email_address' => $email_address, 'imap_address' => $imap_address, 'updated_at' => $updated_at]);
        }
        catch (Exception $e)
        {
            $this->response->setJsonContent(['message' => $e->getMessage()]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getUsers", methods = {"GET", "OPTIONS"})
     */
    public function GetUsersAction()
    {
        $role = $this->request->get('role');
        $offset = $this->request->get('offset');
        $limit = $this->request->get('limit');
        if($offset == null)
        {
            $offset = 0;
        }
        if($limit == null)
        {
            $limit = 10;
        }
        $users = User::find([
            'conditions' => 'role=?1',
            'bind' => [1 => $role],
            'columns' => 'id, name, role, created_at',
            'order' => 'role ASC',
            'limit' => ['number' => $limit, 'offset' => $offset]
        ]);
        $return = array();
        foreach($users as $user)
        {
            $return[] = ["uid" => $user->id, "username" => $user->name, "role" => $user->role, "created_at" => $user->created_at];
        }
        $this->response->setJsonContent($return);
        $this->response->send();
        return;
    }

    /**
     * @Route("/deleteUser", methods = {"GET", "DELETE", "OPTIONS"})
     */
    public function DeleteUserAction()
    {
        $user_id = $this->request->get('user_id');
        $inheritor_id = $this->request->get('inheritor_id');
        if($user_id == null)
        {
            $this->response->setJsonContent(['message' => 'No User_id!']);
            $this->response->send();
            return;
        }
        $user = User::findFirst([
            'conditions' => 'id=?1',
            'bind' => [1 => $user_id]
        ]);
        if($user == null)
        {
            $this->response->setJsonContent(['message' => 'id not exist!']);
            $this->response->send();
            return;
        }
        $method = $this->request->getMethod();
        $user_array = $user->toArray();
        if($method == 'GET')
        {
            $inheritors = User::find([
                'conditions' => 'role=?1 AND id<>?2',
                'bind' => [1 => $user_array['role'], 2 => $user_id]
            ]);
            if($inheritors->getFirst() == null)
            {
                $this->response->setJsonContent(['message' => '该成员无法替代!']);
            }
            else
            {
                $inheritorList = array();
                foreach ($inheritors as $inheritor) {
                    $inheritorList[] = ['id' => $inheritor->id, 'role' => $inheritor->role, 'username' => $inheritor->name, 'created_at' => $inheritor->created_at];
                }
                $this->response->setJsonContent(['inheritorList' => $inheritorList]);
            }
        }
        elseif($method == 'DELETE')
        {
            if($inheritor_id == null)
            {
                $this->response->setJsonContent(['message' => 'No Inheritor_id']);
            }
            elseif($user->delete() == false)
            {
                $messages = "Delete Error:<br/>";
                foreach ($user->getMessages() as $message) {
                    $messages = $messages.$message."<br/>";
                }
                $this->response->setJsonContent(['message' => $messages]);
            }
            else
            {
                if($user_array['role'] == 'dispatcher')
                {
                    $receiveMail = ReceiveMail::find([
                        'conditions' => 'dispatcher_id=?1',
                        'bind' => [1 => $user_id]
                    ]);
                    foreach ($receiveMail as $mail) {
                        $mail->dispatcher_id = $inheritor_id;
                        $mail->save();
                    }
                }
                elseif($user_array['role'] == 'handler')
                {
                    $receiveMail = ReceiveMail::find([
                        'conditions' => 'handler_id=?1',
                        'bind' => [1 => $user_id]
                    ]);
                    $replyMail = ReplyMail::find([
                        'conditions' => 'handler_id=?1',
                        'bind' => [1 => $user_id]
                    ]);
                    foreach ($receiveMail as $mail) {
                        $mail->handler_id = $inheritor_id;
                        $mail->save();
                    }
                    foreach ($replyMail as $mail) {
                        $mail->handler_id = $inheritor_id;
                        $mail->save();
                    }
                }
                elseif($user_array['role'] == 'assessor')
                {
                    $replyMail = ReplyMail::find([
                        'conditions' => 'assessor_id=?1',
                        'bind' => [1 => $user_id]
                    ]);
                    foreach ($replyMail as $mail) {
                        $mail['assessor_id'] = $inheritor_id;
                        $mail->save();
                    }
                }
                $this->response->setJsonContent(['message' => 'Success!']);
            }
        }
        $this->response->send();
        return;
    }
}