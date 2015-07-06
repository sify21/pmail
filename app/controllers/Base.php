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
    }
}

