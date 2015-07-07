<?php
/**
 * @RoutePrefix("/auth")
*/

class AuthController extends Base
{
    /**
     * @Route("/login", methods = {"POST", "OPTIONS"})
     */
    public function LoginAction()
    {
        //Post传过来的是一个无名的json数据，所以只能getRawBody
        $info= $this->request->getJsonRawBody();
        if(!isset($info->username)||!isset($info->password))
        {
            $this->response->setJsonContent(['message' => 'No Data!']);
            $this->response->send();
            return;
        }
        $username = $info->username;
        $password = $info->password;
        $user=Users::findFirst([
            'conditions' => 'name=?1',
            'bind' => [1 => $username]
        ]);
        if($user == null)
        {
            $this->response->setJsonContent(['message' => '用户不存在']);
        }
        elseif( $user->password != $password )
        {
            $this->response->setJsonContent(['message' => '密码错误', ]);
        }
        else
        {
            $user_array = $user->toArray();
            $this->session->set('user_id', $user_array['id']);
            $this->session->set('user_name', $user_array['name']);
            $this->session->set('user_role', $user_array['role']);
            $this->response->setJsonContent(['user_id' => $this->session->get('user_id'), 'user_name' => $this->session->get('user_name'), 'user_role' => $this->session->get('user_role')]);
        }
        $this->response->send();
        return;
    }
}