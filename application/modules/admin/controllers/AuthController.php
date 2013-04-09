<?php

class Admin_AuthController extends App_Controller_Action
{

      
    public function init() {
        parent::init();
    }



    public function indexAction()
    {   

        $this->_helper->layout->setLayout('login');
        
        if ($this->_request->isPost()) {            
            
            $data = $this->_getAllParams();
            
            $f = new Zend_Filter_StripTags();
            
            $email = $f->filter($data['email']);
            $clave = $f->filter($data['clave']);
            /*
            $empresa = new App_Model_Empresa();
            $valido = $empresa->loguinUsuario($email, $clave, array(App_Model_Empresa::TIPO_ADMIN));
            
            if (Zend_Auth::getInstance()->hasIdentity()) {
                
                $auth = Zend_Auth::getInstance();
                $estado = $auth->getStorage()->read()->estado;
                
                 if ($estado  == App_Model_Empresa::ESTADO_PORCONFIRMAR) {
                    $this->_flashMessenger->addMessage("Su cuenta está creada pero aún no ha sido activada");
                    $this->_redirect($this->view->url(array("module" => "admin",
                    "controller" => "auth",
                    "action" => "index")));
                }else{
                        $this->_redirect($this->view->url(array("module" => "admin",
                            "controller" => "empresa",
                            "action" => "mis-datos")));
                }
                
            }
            else {
                $this->_helper->redirector->gotoUrl('/admin/');
            }
            */
             
                       
            if ($this->autentificateUser($email, $clave)) {
               
                $data = $this->getRequest()->getPost();
                
                 $auth = Zend_Auth::getInstance();
                $estado = $auth->getStorage()->read()->estado;
                
                 if ($estado  == App_Model_Empresa::ESTADO_PORCONFIRMAR) {
                    $this->_flashMessenger->addMessage("Su cuenta está creada pero aún no ha sido activada");
                    $this->_redirect($this->view->url(array("module" => "admin",
                    "controller" => "auth",
                    "action" => "index")));
                }else{
                        $this->_redirect($this->view->url(array("module" => "admin",
                            "controller" => "empresa",
                            "action" => "mis-datos")));
                }
                
            }else{
                $this->_flashMessenger->addMessage("Verifique sus credenciales");
                    $this->_redirect($this->view->url(array("module" => "admin",
                    "controller" => "auth",
                    "action" => "index")));
            }
            
            
        }
    
    } 
    public function logoutAction()
    {       	
        $this->_helper->layout->disableLayout();
        
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect($this->view->url(array("module" => "admin",
                            "controller" => "auth",
                            "action" => "index")));
        
        /*
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {            
            $data = $auth->getStorage()->read();
            $auth->clearIdentity();
            $this->_redirect($this->view->url(array("module" => "admin",
                            "controller" => "auth",
                            "action" => "index")));
        } else {
            $this->_helper->redirector->gotoUrl('/admin');
        }*/

    } 

}

