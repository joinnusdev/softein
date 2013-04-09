<?php

class Default_RegistroController extends App_Controller_Action_Portal
{

    public function init()
    {
        parent::init();
        /* Initialize action controller here */        
    }
    
    public function indexAction()
    {       	
      $this->_helper->layout->setLayout('login');
        
    }
  

}

