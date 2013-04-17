<?php

class Admin_ContactoController extends App_Controller_Action_Admin
{

    public function init()
    {
        parent::init();
    }
    
    public function indexAction()
    {     
        $modelContacto = new App_Model_Contacto();
        $listaContacto = $modelContacto->listarContacto();
        $this->view->listaContacto = $listaContacto;
        
        
    }
    
    public function crearAction()
    {
         $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );
        
        $modelContacto = new App_Model_Contacto();
        $total = $modelContacto->listarContacto();

        if(count($total)==3){

            $this->_flashMessenger->addMessage("Ya tiene 3 Contactos Registrados");
            $this->_redirect('/admin/contacto');
        }
        
        
        
        $form = new App_Form_CrearContacto();
        $this->view->form = $form; 
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
            
            if ($form->isValid($data)) {
                
                $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['idEmpresa'] =  $this->authData->idEmpresa;
                $data['fechaRegistro'] = $fechaRegistro;
                $data['estado'] = App_Model_Contacto::ESTADO_ACTIVO;
                $id = $modelContacto->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Contacto creado con exito");
                $this->_redirect('/admin/contacto');
                
            } else {
                $form->populate($data);                
            }
        }
    }
    
    public function editarAction()
    {
        
         $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );
        
        $modelContacto = new App_Model_Contacto();
        $form = new App_Form_CrearContacto();
        $id = $this->_getParam('id');
        $contacto = $modelContacto->getContactoPorId($id);
        $form->populate($contacto);        
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();            
             $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
            $data['fechaRegistro'] = $fechaRegistro;
            $data['estado'] = App_Model_Contacto::ESTADO_ACTIVO;
            $data['idContacto'] = $id;
            if ($form->isValid($data)) {                
                $id = $modelContacto->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Contacto editado con éxito");
                $this->_redirect('/admin/contacto');
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
    }
    
    public function eliminarAction()
    {
        
        $modelContacto = new App_Model_Contacto();
        $id = $this->_getParam('id');   
        $eliminar = $modelContacto->eliminarContacto($id);      
        $this->_flashMessenger->addMessage("Contacto eliminado con exito");
        $this->_redirect('/admin/contacto');
    }
    

}

