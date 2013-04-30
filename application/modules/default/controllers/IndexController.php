<?php

class Default_IndexController extends App_Controller_Action_Portal
{

    public function init()
    {
        parent::init();
        /* Initialize action controller here */        
    }
    
    public function indexAction()
    {       	
         $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        
    }
    public function index2Action()
    {       
        
    }    

}

