<?php

class Admin_ConsorcioController extends App_Controller_Action_Admin
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
        $model= new App_Model_Empresa();
        $idEmpresa = $this->view->authData->idEmpresa;
        $lista = $model->getConsorciosEmpresa($idEmpresa);        
        $this->view->lista = $lista;
        
    }
    
    public function editarAction(){
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );         
        $idEmpresa = $this->_getParam("id");        
        $modelContacto = new App_Model_Contacto();
        $listaContacto = $modelContacto->listarContacto($idEmpresa);
        $this->view->listaContacto = $listaContacto;
        $this->view->empresaConsorcio = $idEmpresa;
        
        $form = new App_Form_CrearEmpresa();
        $modelEmpresa = new App_Model_Empresa();
        $empresa = $modelEmpresa->getEmpresaPorId($idEmpresa);
       
        $form->isValid($empresa);
        $fechaConstitucion=implode('-',array_reverse(explode('-',$empresa['fechaConstitucion'])));
        $form->getElement('fechaConstitucion')->setValue($fechaConstitucion);
        $this->view->fechaConstitucion = $fechaConstitucion;        
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();            
            
                $fechaConstitucion=implode('-',array_reverse(explode('-',$data['fechaConstitucion'])));
                $modelEmpresa = new App_Model_Empresa();                
                $data['idEmpresa'] = $idEmpresa;
                $data['fechaConstitucion'] = $fechaConstitucion;
                $data['nroDocumento'] = $data['nroDocumento'];
                $data['fechaUltimoAcceso'] = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['utimaIp'] = $modelEmpresa->_getRealIP();
                $id = $modelEmpresa ->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Datos Actualizados");
                $this->_redirect('/admin/consorcio');
                
            
        }
    }
    
    
    public function crear1Action()
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
    
    public function editar1Action()
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
    public function crearAction(){
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );                 
        
        $form = new App_Form_CrearEmpresa();
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();            
            
                $fechaConstitucion=implode('-',array_reverse(explode('-',$data['fechaConstitucion'])));
                $modelEmpresa = new App_Model_Empresa();
                $data['consorcio'] = $this->view->authData->idEmpresa;
                $data['fechaConstitucion'] = $fechaConstitucion;
                $data['fechaRegistro'] = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['fechaUltimoAcceso'] = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['utimaIp'] = $modelEmpresa->_getRealIP();
                $id = $modelEmpresa ->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Consorcio Registrado");
                $this->_redirect('/admin/consorcio');
                
            
        }
    }
    
    public function experienciaAction()
    {
        $idEmpresa = $this->_getParam("empresa");
        if ($idEmpresa){
        $modelExperiencia= new App_Model_Experiencia();
        $listaExperiencia = $modelExperiencia->listarExperiencia($idEmpresa);
        $this->view->listaExperiencia = $listaExperiencia;        
        $this->view->empresa = $idEmpresa;
        
        } else {
            $this->_redirect('/admin/consorcio');
        }
    }
    
    public function experienciaEditarAction()
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
                $this->_flashMessenger->addMessage("Experiencia modificada con éxito");
                $this->_redirect('/admin/consorcio/');
                
            /*} else {
                $form->populate($data);                
            }*/
        }
        $this->view->form = $form;
    }
    public function experienciaEliminarAction()
    {
        $modelExperiencia = new App_Model_Experiencia();
        $id = $this->_getParam('id');
        $modelExperiencia->eliminarExperiencia($id);
        $this->_flashMessenger->addMessage("Experiencia eliminada con exito");
        $this->_redirect('/admin/consorcio');
    }
    
    public function experienciaCrearAction()
    {
        $idEmpresa = $this->_getParam("empresa");
        if ($idEmpresa) {
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
                $data['idEmpresa'] =  $idEmpresa;
                $id = $modelExperiencia->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Experiencia creada con exito");
                $this->_redirect('/admin/consorcio/experiencia/empresa/'.$idEmpresa);
                
            /*} else {
                $form->populate($data);                
            }*/
        }
    }
    }
    

}

