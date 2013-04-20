<?php

class Admin_EmpresaController extends App_Controller_Action_Admin
{

   public function init()
    {
        parent::init();
        /* Initialize action controller here */
        
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
    
    public function misDatosAction(){
        /*$this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        ); */
        $modelContacto = new App_Model_Contacto();
        $listaContacto = $modelContacto->listarContacto();
        $this->view->listaContacto = $listaContacto;
        
        
        $idEmpresa = $this->view->authData->idEmpresa;
        
        $form = new App_Form_CrearEmpresa();
        $modelEmpresa = new App_Model_Empresa();
        $empresa = $modelEmpresa->getEmpresaPorId($idEmpresa);
        
        $form->populate($empresa);  
        $fechaConstitucion=implode('-',array_reverse(explode('-',$empresa['fechaConstitucion'])));
        $form->getElement('fechaConstitucion')->setValue($fechaConstitucion);
       
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
            
                $fechaConstitucion=implode('-',array_reverse(explode('-',$data['fechaConstitucion'])));
                $modelEmpresa = new App_Model_Empresa();
                $idEmpresa = $this->view->authData->idEmpresa;
                $data['idEmpresa'] = $idEmpresa;
                $data['fechaConstitucion'] = $fechaConstitucion;
                $data['nroDocumento'] = $data['nroDocumento'];
                $data['clave'] = md5($data['clave']);
                $id = $modelEmpresa ->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Datos Actualizados");
                $this->_redirect('/admin/empresa/mis-datos');
                
            
        }
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
         $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/form/validar.css'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/scriptaculous/lib/prototype.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/scriptaculous/src/scriptaculous.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jsvalidate.js'
        );
   
        
        
        
        /*
        $modelUsuario = new App_Model_Usuario();
        $id = $this->_getParam('id');
        $data = array(
            'idusuario' => $id,
            'estado' => App_Model_Usuario::ESTADO_ELIMINADO
        );        
        
        $modelUsuario->actualizarDatos($data);
        $this->_flashMessenger->addMessage("Usuario eliminado con exito");
        $this->_redirect('/admin/usuario');
       
         */
    }
    

}

