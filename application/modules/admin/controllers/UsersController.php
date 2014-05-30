<?php

class Admin_UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
      $mapper = new Model_UserMapper;
      $this->view->people = $mapper->fetchAll();
    }

    public function createAction()
    {
      
    }

    public function viewAction()
    {
        // action body
    }


}





