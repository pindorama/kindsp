<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
      $form = $this->_form = new Form_LoginForm();
    $this->_helper->layout()->varname = $form;
    }

    public function indexAction()
    {
        // action body
    }


}

