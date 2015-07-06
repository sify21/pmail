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
        $user=Users::findFirst([
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
            $user=new Users();
            $user->name = $name;
            $user->password = $password;
            $user->role = $role;
            $user->created_at = round(microtime(true) * 1000);
            $this->response->setJsonContent(['name' => $user->name, 'password' => $user->password, 'role' => $user->role, 'created_at' => $user->created_at]);
            $user->save();
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getEmailConf", methods = {"GET", "OPTIONS"})
     */
    public function GetEmailConfAction()
    {
        $filePath = __DIR__.'/../config/email.json';
        $jsonString = file_get_contents($filePath);
        $jsonObj = json_decode($jsonString);
        $this->response->setJsonContent($jsonObj);
        $this->response->send();
        return;
    }

    /**
     * @Route("/confEmail", methods = {"PUT", "OPTIONS"})
     */
    public function ConfEmailAction()
    {
        $info = $this->request->getJsonRawBody();
        if(!isset($info->email_address)||!isset($info->imap_address)||!isset($info->password)||!isset($info->passwordConfirmation))
        {
            $this->response->setJsonContent(['message' => 'No Data!']);
            $this->response->send();
            return;
        }
        $email_address = $info->email_address;
        $imap_address = $info->imap_address;
        $password = $info->password;
        $passwordConfirmation = $info->passwordConfirmation;
        $updated_at = round(microtime(true) * 1000);
        if($password != $passwordConfirmation)
        {
            $this->response->setJsonContent(['message' => '两次密码不一致']);
        }
        else
        {
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
        $users = Users::find([
            'conditions' => 'role=?1',
            'bind' => [1 => $role],
            'columns' => 'id, name, role, created_at',
            'order' => 'id ASC',
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
     * @Route("/deleteUser", methods = {"DELETE", "OPTIONS"})
     */
    public function DeleteUserAction()
    {
        $info = $this->request->getJsonRawBody();
        if(!isset($info->user_id))
        {
            $this->response->setJsonContent(['message' => 'No Data!']);
            $this->response->send();
            return;
        }
        $user = Users::findFirst([
            'conditions' => 'id=?1',
            'bind' => [1 => $info->id]
        ]);
        if($user == null)
        {
            $this->response->setJsonContent(['message' => 'id not exist!']);
        }
        else
        {
            $user->delete();
        }
    }
}