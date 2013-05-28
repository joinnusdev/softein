<?php

class Admin_ExperienciaController extends App_Controller_Action_Admin
{

    public function init()
    {
        parent::init();
    }
    
    public function indexAction()
    {
        $modelExperiencia= new App_Model_Experiencia();
        $listaExperiencia = $modelExperiencia->listarExperiencia($this->authData->idEmpresa);
        $this->view->listaExperiencia = $listaExperiencia;        
    }
    
    public function crearAction()
    {
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );
        
        $form = new App_Form_CrearExperiencia();
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
            
            //if ($form->isValid($data)) {
                $modelExperiencia = new App_Model_Experiencia();
                $data['idEmpresa'] =  $this->authData->idEmpresa;
                $id = $modelExperiencia->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Experiencia creada con exito");
                $this->_redirect('/admin/experiencia');
                
            /*} else {
                $form->populate($data);                
            }*/
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
        
        $modelExperiencia = new App_Model_Experiencia();
        $form = new App_Form_CrearExperiencia();
        $id = $this->_getParam('id');
        $this->view->experiencia = $experiencia = $modelExperiencia->getExperienciaPorId($id);
        $form->populate($experiencia);        
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();            
            $data['idDetalleEmpresa'] = $id;
            //if ($form->isValid($data)) {                
                $id = $modelExperiencia->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Experiencia editado con éxito");
                $this->_redirect('/admin/experiencia');
                
            /*} else {
                $form->populate($data);                
            }*/
        }
        $this->view->form = $form;
    }
    
    public function eliminarAction()
    {
        
        $modelExperiencia = new App_Model_Experiencia();
        $id = $this->_getParam('id');
        $modelExperiencia->eliminarExperiencia($id);
        $this->_flashMessenger->addMessage("Experiencia eliminada con exito");
        $this->_redirect('/admin/experiencia');
    }
    

}

