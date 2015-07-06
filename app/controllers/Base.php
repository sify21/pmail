<?php
/**
 * 所有控制器的基类，负责公用任务处理
 */
class Base extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        $this->view->disable();
        $this->response->setContentType('application/Json','UTF-8');

        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,HEAD,OPTIONS,PATCH');
        //跨域访问的时候非get请求会先发一个options请求，确定可以连接才会发送真正的请求，所以api接口的route至少要满足两种请求的方法，一个是options，一个是真正的请求的方法
    }
}

