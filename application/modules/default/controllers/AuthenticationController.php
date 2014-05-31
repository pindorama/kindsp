<?php

class Default_AuthenticationController extends Zend_Controller_Action
{
    
    protected $_statusMessenger;
    protected $_errorMessenger;
    protected $_form;

    public function init()
    {
        
        $this->view->documentClasses = array('default', 'authentication');
        $this->_statusMessenger = $this->_helper->flashMessenger;
        $this->_errorMessenger = new Zend_Controller_Action_Helper_FlashMessenger();
        $this->_errorMessenger->setNamespace('error');
        $this->view->statusMessages = $this->_statusMessenger->getMessages();
        
    $form = $this->_form = new Form_LoginForm();
    $this->_helper->layout()->varname = $form;
       
    }

    public function indexAction()
    {
        // action body
    }
    
     public function loginAction()
    {
        $this->view->documentClasses = array('default', 'login');
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_statusMessenger->addMessage('Sie sind eingeloggt.');
            $this->_redirect('/default');
        }
       // $this->view->form = $this->_getLoginForm();
        $this->view->errorMessages = $this->_errorMessenger->getMessages();
    }
    
    
    public function checkloginAction() {
        
          	// Zurueck zu index, falls kein POST-Request
    	// hereinkommt
        if (!$this->_request->isPost()) {
            $this->_errorMessenger->addMessage('Sie k&ouml;nnen sich nur &uuml;ber das Login-Formular anmelden.');
        	return $this->_helper->redirector('index');
        }
        

        // falls das Formular falsch ausgefuellt ist, zurueck!
    if (!$this->_form->isValid($this->_request->getPost())) {
        	$this->view->form = $this->_form;
        	return $this->render('login');
        }
        
        $authAdapter = new Zend_Auth_Adapter_DbTable(
        	Zend_Db_Table::getDefaultAdapter(),
        	'users',
        	'username',
        	'password'
        );
        $params = $this->_form->getValues();
        $authAdapter->setIdentity($params['username'])
        	->setCredential(md5($params['password']));
        $auth = Zend_Auth::getInstance();
        $authValid = $auth->authenticate($authAdapter)->isValid();
        
        if (!$authValid) {
        	$this->view->form = $this->_form;
       	    $this->_errorMessenger->addMessage('Falsche Benutzerdaten.');
        	return $this->_helper->redirector('login');
        }
        else
        {
                $identity = $authAdapter->getResultRowObject();
                    //we need some kind of persistent storage
                    //we get from zend_Auth::getInstance
             
                    $authStorage = $auth->getStorage();
                    //write the identiy in a persinten store, by default we use zend session
                    $authStorage->write($identity);
        
                $this->_redirect('http://kinderspielplatz.local/');
        }
    }

//logout erase all the session the strop in the pestintent storage
    public function logoutAction() {
        //all the authentication is now cleared
        Zend_Auth::getInstance()->clearIdentity();
        //redirect to default/index/index
        $this->_redirect('authentication/login');
    }

  


}