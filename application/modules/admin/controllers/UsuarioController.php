<?php

class Admin_UsuarioController extends App_Controller_Action_Admin
{

    public function init()
    {
        parent::init();
    }
    
    public function indexAction()
    {      	
        $modelUsuario = new App_Model_Usuario();
        $listaUsuario = $modelUsuario->listarUsuario();
        $this->view->listaUsuario = $listaUsuario;
    }
    
    public function crearAction()
    {
        $form = new App_Form_CrearUsuario();
        $this->view->form = $form; 
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
            
            if ($form->isValid($data)) {
                $modelUsuario = new App_Model_Usuario();
                $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['fechaRegistro'] = $fechaRegistro;
                $data['tipoUsuario'] = App_Model_Usuario::TIPO_ADMIN;
                $data['estado'] = App_Model_Usuario::ESTADO_ACTIVO;
                $data['clave'] = md5($data['clave']);
                $id = $modelUsuario->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Usuario creado con exito");
                $this->_redirect('/admin/usuario');
                
            } else {
                $form->populate($data);                
            }
        }
    }
    
    public function editarAction()
    {
        $modelUsuario = new App_Model_Usuario();
        $form = new App_Form_CrearUsuario();
        $id = $this->_getParam('id');
        $usuario = $modelUsuario->getUsuarioPorId($id);
        $form->populate($usuario);        
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();            
            $data['idusuario'] = $id;
            if ($form->isValid($data)) {                
                $id = $modelUsuario->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Usuario editado con éxito");
                $this->_redirect('/admin/usuario');
                
            } else {
                $form->populate($data);                
            }
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

