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
        $listaExperiencia = $modelExperiencia->listarExperiencia();
        $this->view->listaExperiencia = $listaExperiencia;        
    }
    
    public function crearAction()
    {   
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
        $modelExperiencia = new App_Model_Experiencia();
        $form = new App_Form_CrearExperiencia();
        $id = $this->_getParam('id');
        $experiencia = $modelExperiencia->getExperienciaPorId($id);
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
        
        $modelUsuario = new App_Model_Usuario();
        $id = $this->_getParam('id');
        $data = array(
            'idusuario' => $id,
            'estado' => App_Model_Usuario::ESTADO_ELIMINADO
        );        
        
        $modelUsuario->actualizarDatos($data);
        $this->_flashMessenger->addMessage("Usuario eliminado con exito");
        $this->_redirect('/admin/usuario');
    }
    

}

