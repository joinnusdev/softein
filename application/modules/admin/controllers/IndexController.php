<?php

class Admin_IndexController extends App_Controller_Action_Admin
{

    public function init()
    {
        parent::init();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            echo $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        }
         
        
    }
    
    public function indexAction()
    {       	
        
        
    } 

}

