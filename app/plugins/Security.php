<?php
    /**
     * Created by PhpStorm.
     * User: XYN
     * Date: 10/14/14
     * Time: 11:40 AM
     */
    use Phalcon\Events\Event, Phalcon\Mvc\User\Plugin, Phalcon\Mvc\Dispatcher, Phalcon\Acl;

    class Security
        extends Plugin
    {
        public function __construct($dependencyInjector)
        {
            $this->_dependencyInjector = $dependencyInjector;
        }

        public function getAcl()
        {
            if (!isset($this->persistent->acl))
            {
                $acl = new Phalcon\Acl\Adapter\Memory();
                $acl->setDefaultAction(Phalcon\Acl::DENY);
                //Register roles
                $roles = ['admin' => new Phalcon\Acl\Role('admin'),
                          'dispatcher' => new Phalcon\Acl\Role('dispatcher'),
                          'handler' => new Phalcon\Acl\Role('handler'),
                          'assessor' => new Phalcon\Acl\Role('assessor')];
                foreach ($roles as $role)
                {
                    $acl->addRole($role);
                }
                //All resources
                $resources = ['admin' => ['*'],
                              'assessor' => ['*'],
                              'common' => ['*'],
                              'dispatcher' => ['*'],
                              'handler' => ['*']];
                foreach ($resources as $controller => $actions)
                {
                    //Resource类对应某个Controller
                    $acl->addResource(new Phalcon\Acl\Resource($controller), $actions);
                }
                //Grant access to users
                $acl->allow('admin', 'admin', '*');
                $acl->allow('assessor', 'assessor', '*');
                $acl->allow('dispatcher', 'dispatcher', '*');
                $acl->allow('handler', 'handler', '*');
                foreach($roles as $role)
                {
                    $acl->allow($role->getName(),'common','*');
                }
				
                $this->persistent->acl = $acl;
            }

            return $this->persistent->acl;
        }

        public function beforeDispatch(Event $event, Dispatcher $dispatcher)
        {
            $user_role = $this->session->get("user_role");
            if ($user_role == null )
            {
                $role = "Guests";
            }
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();
            $acl = $this->getAcl();
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Acl::ALLOW)
            {
                $dispatcher->forward(array('controller' => 'admin',
                                           'action' => 'login'));
                return false;
            }
        }
    }