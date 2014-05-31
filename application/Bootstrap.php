<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    
        protected function _initHead() {
        //getBaseUrl
            
            
        $this->bootstrap('frontcontroller'); 
        $controller = Zend_Controller_Front::getInstance();
        $baseUrl = $controller->getBaseUrl();
        
       $view = new Zend_View();
       

        $view->headTitle('kinderspielplatz')
		->setSeparator(' - ')
		->setDefaultAttachOrder(Zend_View_Helper_Placeholder_Container::PREPEND);
        
       $view->headScript()
             ->appendFile($baseUrl . '/js/jquery.js')
             ->appendFile($baseUrl . '/js/jquery-2.1.0.min.js')
	     ->appendFile($baseUrl . '/js/bootstrap.js')
             ->appendFile($baseUrl . '/js/jquery-ui.js')
             ->appendFile($baseUrl . '/js/jquery-ui-1.10.4.custom.min.js')
             ->appendFile($baseUrl . '/js/jquery.maskedinput.js')
             ->appendFile($baseUrl . '/js/html5shiv.js', 'text/javascript', array('conditional' => 'lt IE 9'));
        
        $view->headLink()
	     ->appendStylesheet($baseUrl . 'css/jquery-ui.css', 'screen')
             ->appendStylesheet($baseUrl . 'css/style.css', 'screen')
             ->appendStylesheet($baseUrl . 'css/bootstrap.css', 'screen')
             ->appendStylesheet($baseUrl . 'css/font-awesome.css', 'screen')
             ->appendStylesheet($baseUrl . 'css/font-awesome-ie7.min.css', 'screen')
             ->appendStylesheet($baseUrl . 'css/global.css', 'screen')
             ->appendStylesheet($baseUrl . 'css/redmond/jquery-ui-1.10.4.custom.css', 'screen')
             ->appendStylesheet($baseUrl . 'css/bootstrap-responsive.css', 'screen');
        

        
    }

    private $_acl = null;

    //This method loading at all first things  from our aplications
    /*
     * Loading the modules admin,default,playground
     * Set the role is already running
     * Call plugin AccessCheck to check all the resources (controllers,actions,view) from all of modules
     */
    
    protected function _initAutoload() {
        /*
         * Modules separated Admin,Default,library
         * load the Module default as default
         */
        $modelLoader = new Zend_Application_Module_Autoloader(array(
            //that's why you dont need append namespace for default
            'namespace' => '',
            'basePath' => APPLICATION_PATH . '/modules/default'));

        //look if there is a Identity(role = users,admin,guest)
      if(Zend_Auth::getInstance()->hasIdentity()){
            Zend_Registry::set('role', Zend_Auth::getInstance()->getStorage()->read()->role);
        }else {
            //default value
            Zend_Registry::set('role', 'guests');
            
        }
        //create a object based in Playground acl
        $this->_acl = new Model_PlaygroundAcl;


        /*
         * Register for the plugin Accesscheck, we need instance of Front Controller
         * Diese class(Front Controller) is responsible for loading all of this extras plugins
         * see Plugin AccessCheck
         * Front_Controller wird die Plugin AccessCheckl aufrufen, bevor de
         */

        $fc = Zend_Controller_Front::getInstance();
        //register a new plugin, call the the plugin with the playground_acl
        $fc->registerPlugin(new Plugin_AccessCheck($this->_acl));



        //acl accesseble
        Zend_Registry::set('acl', $this->_acl);
        return $modelLoader;
    }

    
    /**
     * Configs for the layout
     * Set the navigation.xml in the layout view.
     */
    function _initViewHelpers() {
        //resoucer layout, you have in aplication ini declared
        $this->bootstrap('layout');
        //get the resoucer layout(object) from the path in aplication.ini
        $layout = $this->getResource('layout');
        //the layout is like Zend_View work fast the same
        $view = $layout->getView(); {
            
        }

        /*
         * all os those view helpers are available and come from the view instance ($view
         * =layout->getView();) eg.:
         * $view->doctype('HTML4_SRITCT');
         * in the _header you can write <?php echo $this->doctype() ?>
         * 
         */
     

        //it is goin to look for any helpers specifique in modules, but if the viewhelper is not there
        //is going to look inside of this path
        $view->setHelperPath(APPLICATION_PATH . '/helpers', '');

       // $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        // $view->jQuery()->addStylesheet('js/jquery/css/redmond/jquery-ui-1.10.4.custom.css');
        // $view->jQuery()->setLocalPath('/js/jquery/js/jquery-1.10.2.js');
        // $view->jQuery()->setUiLocalPath('/js/jquery/js/jquery-1.10.4.custom.min.js');
        //ZendX_JQuery::enableView($view);
        //i can use dojo ViewHelps in my view and layoutscripts
        //   Zend_Dojo::enableView($view);
        ;

        //come from Zend from xml to array format, nav = container
        /**
         * that only Zend class that's grab a configuration file xml new Zend_Config_Xml
         * and put it into array format, we going to grab the node 'nav' = containter, that
         * you see into the config file navigation.xml
         */
        $navContainerConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        //create a object, you going to create the navigation
        $navContainer = new Zend_Navigation($navContainerConfig);
        //Now you going to push it  to our  Viewhelper, now the navigation you show for each role:guests,users,admins
        //different menu
        $view->navigation($navContainer)->setAcl($this->_acl)->setRole(Zend_Registry::get('role'));
    }

    /*
     * configs for the view 
     */


}

