<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessCheck
 *
 * @author pindorama
 */
class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {

    private $_acl = null;
   

    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
        
    }
    /*
     * this function runs before the controllers and action
     * where i put into the preDispatch method will runs, just before the mvc is compiler together
     * we have to registried it in Bootstrap File
     * See Zend_Controller_Front::getInstance();
     * the preDispatch is called right before  controller and View  being put together, preDispatch before the controller is executed.
     * 
     * Zend_Controller_Request_Abstract $request(parament variable) from Acl Playground,
     * that is not the actually action and controller from the browser
     * That the User(admins,users,guests) is asking to access
     */

   
    /**
     * //pre-despachar, pre-envio
     * @param Zend_Controller_Request_Abstract $request
     * check all resources from PlaygroundAcl from module to controller,action,view
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
    //  $layout = Zend_Layout::getMvcInstance();
    //  $view = $layout->getView();
     // $_form = new Form_LoginForm();
       
       // $front = Zend_Controller_Front::getInstance();
        //$view = $front->getParam('bootstrap')->getResource('view');
      // $view->whatever = $_form;
        //$front = Zend_Controller_Front::getInstance();
        /* @var $view  */
      //  $view = $front->getParam('bootstrap')->getResource('view');
    
       
       /*
        * This is not from actually controller and action from the browser that being runs,
        * This is from ACL playground, the ControllerName (ressources),Module and Action
        * That the User is asking to access, with add new Zend_Acl_Resource
        * get the name of the controller and give to the ressources in der playgroundAcl to compare,
        * together with action and role. that why you go more the once into the acl to check all of add Resources.
        */
      
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $module =$request->getModuleName();
        
        //take the row in the dabase
       /*@magnus
        * for my project that not interessting, because he is redirect the page 
        * all the time to authentication/login, if the login is guest, my login form will all at layout
        * appear 
        * 
        */
        //if he(users) is not allowed to look at the current resquest ressource action, he will be redirect
        //to way of authentication (controller) and login(action)
        
        if (!$this->_acl->isAllowed(Zend_Registry::get('role'), $module.':'.$controller, $action)) {
            //echo 'hi';
            //that ist not the controller from browser, but the intern controller that 
            //redirect to authentication and login, we dont need permission for that
            $request->setControllerName('authentication')
                    ->setActionName('index');
        }
        
       // $this->_acl->setDynamicPermissions();
    }
}

?>
