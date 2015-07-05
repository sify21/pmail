<?php
/**
 * Created by PhpStorm.
 * User: sify
 * Date: 15-6-29
 * Time: 下午11:44
 */

//Normal Router
//$router = new Phalcon\Mvc\Router(false);

//$router->add("/index/k/:params", ["controller" => "index", "action" => "k", "params" => 1])->via(["POST"]);
//$router->add("/test/:controller/:params",["controller" => "test", "action" => '1', 'params' => 2]);


//Annotations Router
$router=new Phalcon\Mvc\Router\Annotations(false);

//read annotations from ** controller if the uri starts with /**
$router->addResource('Test', '/test');
$router->addResource('Handler', '/handler');
$router->addResource('Dispatcher', '/dispatcher');
$router->addResource('Common', '/common');
$router->addResource('Auth', '/auth');
$router->addResource('Assessor', '/assessor');
$router->addResource('Admin', '/admin');