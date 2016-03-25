<?php

namespace QUIZUP\Plugins;

//use Phalcon\Acl;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
    //public $acl = null;
    //public function __construct() {
        // Create the ACL
        $acl = new AclList();

        // The default action is DENY access
        $acl->setDefaultAction(Acl::DENY);

        // Register two roles, Users is registered users
        // and guests are users without a defined identity
        $roles = array(
            'users'  => new Role('Users'),
            'guests' => new Role('Guests')
        );

        foreach ($roles as $role) {
            $acl->addRole($role);
        }

        // Private area resources (backend)
        $privateResources = array(
            'companies'    => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
            'products'     => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
            'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
            'invoices'     => array('index', 'profile'),
            'category' => array('index', 'list', 'add', 'delete', 'edit', 'create')
        );
        foreach ($privateResources as $resource => $actions) {
            $acl->addResource(new Resource($resource), $actions);
        }

        // Public area resources (frontend)
        $publicResources = array(
            'index'    => array('index'),
            'about'    => array('index'),
            'register' => array('index'),
            'errors'   => array('show404', 'show500'),
            'session'  => array('index', 'register', 'start', 'end'),
            'contact'  => array('index', 'send'),
            'login' => array('index'),
            'main' => array('index'),
            'signup' => array('index', 'do', 'confirm')
        );
        foreach ($publicResources as $resource => $actions) {
            $acl->addResource(new Resource($resource), $actions);
        }

        // Grant access to public areas to both users and guests
        foreach ($roles as $role) {
            foreach ($publicResources as $resource => $actions) {
                $acl->allow($role->getName(), $resource, '*');
            }
        }

        // Grant access to private area only to role Users
        foreach ($privateResources as $resource => $actions) {
            foreach ($actions as $action) {
                $acl->allow('Users', $resource, $action);
            }
        }

      //  return $acl;
    //}


        // Check whether the "auth" variable exists in session to define the active role
        $auth = $this->session->get('auth');
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        // Take the active controller/action from the dispatcher
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        // Obtain the ACL list
        //$acl = $this->getAcl();

        // Check if the Role have access to the controller (resource)
        $allowed = $acl->isAllowed($role, $controller, $action);
        if ($allowed != Acl::ALLOW) {

            // If he doesn't have access forward him to the index controller
            //$this->flash->error("You don't have access to this module 2");
            $this->flashSession->error($this->translator->_('LOGIN_FIRST'));
            $dispatcher->forward(
                array(
                    'controller' => 'login',
                    'action'     => 'index'
                )
            );

            // Returning "false" we tell to the dispatcher to stop the current operation
            return false;
        }

    }
}