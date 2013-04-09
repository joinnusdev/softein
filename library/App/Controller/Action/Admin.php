<?php
class App_Controller_Action_Admin extends App_Controller_Action
{
    public function init() 
    {
        parent::init();
        $this->_helper->layout->setLayout('layout-admin');
        
        /*$this->view->headLink()->appendStylesheet($this->view->s('/css/bootstrap3.min.css'), 'all')
                               ->appendStylesheet($this->view->s('/css/styles/admin.css'), 'all')
                               ->appendStylesheet($this->view->s('/css/main.css'), 'all')
                                ->appendStylesheet($this->view->s('/css/fixie.css'), 'all', 'lte IE 8');*/
        
        /*$this->view->headLink()->appendStylesheet($this->view->s('/'))
            ->appendStylesheet($this->view->s('/'))
            ->appendStylesheet($this->view->s('/'))
            ;*/
        

        
        
    }



}