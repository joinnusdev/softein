<?php

class Admin_ConsorcioController extends App_Controller_Action_Admin {

    public function init() {
        parent::init();
        /* Initialize action controller here */

        $auth = Zend_Auth::getInstance();

        if (!$auth->hasIdentity()) {
            echo $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        }
    }

    public function indexAction() {
        $model = new App_Model_Empresa();
        $idEmpresa = $this->view->authData->idEmpresa;
        $lista = $model->getConsorciosEmpresa($idEmpresa);
        $this->view->lista = $lista;
    }

    public function editarAction() {
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );
        $idEmpresa = $this->_getParam("id");        
        $this->view->empresaConsorcio = $idEmpresa;

        $form = new App_Form_CrearEmpresa();
        $modelEmpresa = new App_Model_Empresa();
        $empresa = $modelEmpresa->getEmpresaPorId($idEmpresa);
        
        $form->isValid($empresa);
        $fechaConstitucion = implode('-', array_reverse(explode('-', $empresa['fechaConstitucion'])));
        $form->getElement('fechaConstitucion')->setValue($fechaConstitucion);
        $this->view->fechaConstitucion = $fechaConstitucion;
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {

            $data = $this->getRequest()->getPost();

            $fechaConstitucion = implode('-', array_reverse(explode('-', $data['fechaConstitucion'])));
            $modelEmpresa = new App_Model_Empresa();
            $data['idEmpresa'] = $idEmpresa;
            $data['fechaConstitucion'] = $fechaConstitucion;
            $data['nroDocumento'] = $data['nroDocumento'];
            $data['fechaUltimoAcceso'] = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
            $data['utimaIp'] = $modelEmpresa->_getRealIP();
            $id = $modelEmpresa->actualizarDatos($data);

            $this->_flashMessenger->addMessage("Datos Actualizados");
            $this->_redirect('/admin/consorcio');
        }
    }

    public function crear1Action() {
        $form = new App_Form_CrearUsuario();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {

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

    public function editar1Action() {
        $modelUsuario = new App_Model_Usuario();
        $form = new App_Form_CrearUsuario();
        $id = $this->_getParam('id');
        $usuario = $modelUsuario->getUsuarioPorId($id);
        $form->populate($usuario);
        if ($this->getRequest()->isPost()) {
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

    public function eliminarAction() {
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

    public function crearAction() {
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );

        $form = new App_Form_CrearEmpresa();
        $this->view->form = $form;
        $form->paisEmpresa->setValue("173");
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            $fechaConstitucion = implode('-', array_reverse(explode('-', $data['fechaConstitucion'])));
            $modelEmpresa = new App_Model_Empresa();
            $data['consorcio'] = $this->view->authData->idEmpresa;
            $data['fechaConstitucion'] = $fechaConstitucion;
            $data['fechaRegistro'] = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
            $data['fechaUltimoAcceso'] = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
            $data['utimaIp'] = $modelEmpresa->_getRealIP();
            $id = $modelEmpresa->actualizarDatos($data);

            $this->_flashMessenger->addMessage("Consorcio Registrado");
            $this->_redirect('/admin/consorcio');
        }
    }

    public function experienciaAction() {
        $idEmpresa = $this->_getParam("empresa");
        if ($idEmpresa) {
            $modelExperiencia = new App_Model_Experiencia();
            $listaExperiencia = $modelExperiencia->listarExperiencia($idEmpresa);
            $this->view->listaExperiencia = $listaExperiencia;
            $this->view->empresa = $idEmpresa;
        } else {
            $this->_redirect('/admin/consorcio');
        }
    }

    public function experienciaEditarAction() {
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
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParams();
            $data['idDetalleEmpresa'] = $id;
            //if ($form->isValid($data)) {                
            $id = $modelExperiencia->actualizarDatos($data);
            $this->_flashMessenger->addMessage("Experiencia modificada con éxito");
            $this->_redirect('/admin/consorcio/');

            /* } else {
              $form->populate($data);
              } */
        }
        $this->view->form = $form;
    }

    public function experienciaEliminarAction() {
        $modelExperiencia = new App_Model_Experiencia();
        $id = $this->_getParam('id');
        $modelExperiencia->eliminarExperiencia($id);
        $this->_flashMessenger->addMessage("Experiencia eliminada con exito");
        $this->_redirect('/admin/consorcio');
    }

    public function experienciaCrearAction() {
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
            $form->servicioPais->setValue("173");
            if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();

                //if ($form->isValid($data)) {
                $modelExperiencia = new App_Model_Experiencia();
                $data['idEmpresa'] = $idEmpresa;
                $id = $modelExperiencia->actualizarDatos($data);

                $this->_flashMessenger->addMessage("Experiencia creada con exito");
                $this->_redirect('/admin/consorcio/experiencia/empresa/' . $idEmpresa);

            }
        }
    }
    public function contactoAction()
    {     
        $modelContacto = new App_Model_Contacto();
        $idEmpresa = $this->_getParam("empresa");
        $this->view->empresa = $idEmpresa;
        $listaContacto = $modelContacto->listarContacto($idEmpresa);
        $this->view->listaContacto = $listaContacto;
    }
    
    public function contactoCrearAction() {
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );
        $idEmpresa = $this->_getParam("empresa");
        if ($idEmpresa) {
            $modelContacto = new App_Model_Contacto();
            $total = $modelContacto->listarContacto($idEmpresa);

            if (count($total) == 3) {
                $this->_flashMessenger->addMessage("Ya tiene 3 Contactos Registrados");
                $this->_redirect('/admin/consorcio/contacto/empresa/'.$idEmpresa);
            }

            $form = new App_Form_CrearContacto();
            $this->view->form = $form;
            $this->view->empresa = $idEmpresa;
            
            if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();
                if ($form->isValid($data)) {
                    $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                    $data['idEmpresa'] = $idEmpresa;
                    $data['fechaRegistro'] = $fechaRegistro;
                    $data['estado'] = App_Model_Contacto::ESTADO_ACTIVO;
                    $id = $modelContacto->actualizarDatos($data);

                    $this->_flashMessenger->addMessage("Contacto creado con exito");
                    $this->_redirect('/admin/consorcio/contacto/empresa/'.$idEmpresa);
                } else {
                    $form->populate($data);
                }
            }
        } else {
            $this->_redirect('/admin/consorcio');
        }
    }
    
    public function contactoEditarAction()
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
        $idEmpresa = $this->_getParam('empresa');
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
                $this->_redirect('/admin/consorcio/contacto/empresa/'.$idEmpresa);
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
        $this->view->empresa = $idEmpresa;
    }
    
    public function contactoEliminarAction()
    {        
        $modelContacto = new App_Model_Contacto();
        $id = $this->_getParam('id');   
        $idEmpresa = $this->_getParam('empresa');
        $eliminar = $modelContacto->eliminarContacto($id);      
        $this->_flashMessenger->addMessage("Contacto eliminado con exito");
        $this->_redirect('/admin/consorcio/contacto/empresa/'.$idEmpresa);
    }
    
    public function personalAction()
    {
        $idEmpresa = $this->_getParam('empresa');
        $model= new App_Model_Personal();
        $lista = $model->listarPersonal($idEmpresa);
        if ($lista) {
            $this->view->listaExperiencia = $lista;
            $this->view->empresa = $idEmpresa;
        } else 
            $this->_redirect('/admin');
            
        
    }

    public function personalCrearAction()
    {  
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/admin/personal.js'
        );
        
        $idEmpresa = $this->_getParam('empresa');
        if (!$idEmpresa)
            $this->_redirect("/admin/consorcio");
        $form = new App_Form_CrearPersonal();
        $this->view->form = $form;
        $this->view->empresa = $idEmpresa;
        
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
            
            if ($form->isValid($data)) {
                $model = new App_Model_Personal();
                $data['fechaRegistro'] = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['estado'] = '1';
                $data['idEmpresa'] = $idEmpresa;
                $id = $model->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Personal Creado Correctamente");
                $this->_redirect('/admin/consorcio/personal/empresa/'.$idEmpresa);
                
            } /*else {
                $form->populate($data);                
            }*/
        }
    }
    
    public function personalEditarAction()
    {        
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/admin/personal-editar.js'
        );
        $model = new App_Model_Personal();
        $form = new App_Form_CrearPersonal();
        $id = $this->_getParam('id');
        $idEmpresa = $this->_getParam('empresa');
        $experiencia = $model->getPersonalPorId($id);
        
        $modelEsp = new App_Model_Especialidad();
        $espec = $modelEsp->getComboEspecialidad($experiencia['idProfesion']);
        $modelSubEsp = new App_Model_SubEspecialidad();
        $subespec = $modelSubEsp->getComboSubEspecialidad($experiencia['idSubEspecialidad']);
        $form->getElement('idEspecialidad')->setMultiOptions(
            array("0" => "--- Seleccionar ---")+$espec);
        $form->getElement('idSubEspecialidad')->setMultiOptions(
            array("0" => "--- Seleccionar ---")+$subespec);
        
        $form->populate($experiencia);        
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();            
            $data['idPersonal'] = $id;
            //if ($form->isValid($data)) {                
                $id = $model->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Personal actualizado con éxito");
                $this->_redirect('/admin/consorcio/personal/empresa/'.$idEmpresa);
                
            /*} else {
                $form->populate($data);                
            }*/
        }
        $this->view->form = $form;
    }
    
    public function personalEliminarAction()
    {        
        $model = new App_Model_Personal();
        $id = $this->_getParam('id');
        $idEmpresa = $this->_getParam('empresa');
        $model->eliminarPersonal($id);
        $this->_flashMessenger->addMessage("Personal eliminado correctamente");
        $this->_redirect('/admin/consorcio/personal/empresa/'.$idEmpresa);
    }
    
    public function referenciaAction()
    {     
        $model = new App_Model_Referencia();
        $idEmpresa = $this->_getParam("empresa");
        $this->view->empresa = $idEmpresa;
        $lista = $model->listarReferencia($idEmpresa);
        $this->view->listaContacto = $lista;
    }
    
    public function referenciaCrearAction() {
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );        
        $idEmpresa = $this->_getParam("empresa");
        if ($idEmpresa) {
            $modelRef = new App_Model_Referencia();
            $form = new App_Form_CrearContacto();
            $this->view->form = $form;
            $this->view->empresa = $idEmpresa;
            
            if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();
                if ($form->isValid($data)) {
                    $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                    $data['idEmpresa'] = $idEmpresa;
                    $data['fechaRegistro'] = $fechaRegistro;
                    $data['estado'] = App_Model_Contacto::ESTADO_ACTIVO;
                    $id = $modelRef->actualizarDatos($data);

                    $this->_flashMessenger->addMessage("Referencia creada con exito");
                    $this->_redirect('/admin/consorcio/referencia/empresa/'.$idEmpresa);
                } else {
                    $form->populate($data);
                }
            }
        } else {
            $this->_redirect('/admin/consorcio');
        }
    }
    
    public function referenciaEditarAction()
    {        
         $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );
        
        $modelRef = new App_Model_Referencia();
        $form = new App_Form_CrearContacto();
        $id = $this->_getParam('id');
        $idEmpresa = $this->_getParam('empresa');
        $referencia = $modelRef->getReferenciaPorId($id);
        $form->populate($referencia);
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();             
            $data['estado'] = App_Model_Contacto::ESTADO_ACTIVO;
            $data['idReferencia'] = $id;
            if ($form->isValid($data)) {
                $id = $modelRef->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Referencia editada con éxito");
                $this->_redirect('/admin/consorcio/referencia/empresa/'.$idEmpresa);
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
        $this->view->empresa = $idEmpresa;
    }
    
    public function personalExplaboralAction() {
        $idPersonal = $this->_getParam("id");
        $empresa = $this->_getParam("empresa");
        if ($idPersonal) {
            $modelExperiencia = new App_Model_Experiencia();
            $listaExperiencia = $modelExperiencia->listarExperiencia(NULL, $idPersonal);
            $this->view->listaExperiencia = $listaExperiencia;
            $this->view->empresa = $idPersonal;
            $this->view->personal = $empresa;
        } else {
            $this->_redirect('/admin/consorcio');
        }
    }
    
    public function personalExplaboralCrearAction() {
        $idPersonal = $this->_getParam("personal");
        if ($idPersonal) {
            $this->view->headScript()->appendFile(
                    $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
            );
            $this->view->headScript()->appendFile(
                    $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
            );

            $form = new App_Form_CrearExperiencia();
            $this->view->form = $form;

            if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();

                //if ($form->isValid($data)) {
                $modelExperiencia = new App_Model_Experiencia();
                $data['idPersonal'] = $idPersonal;
                $id = $modelExperiencia->actualizarDatos($data);

                $this->_flashMessenger->addMessage("Experiencia Laboral creada con exito");
                $this->_redirect('/admin/consorcio/personal-explaboral/id/' . $idPersonal);

            }
        } else {
            $this->_redirect('/admin/consorcio');
            
        }
    }
    
    public function personalExplaboralEditarAction() {
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );

        $modelExperiencia = new App_Model_Experiencia();
        $form = new App_Form_CrearExperiencia();
        $id = $this->_getParam('id');
        $personal = $this->_getParam('personal');
        $idempresa = $this->_getParam('empresa');
        $this->view->experiencia = $experiencia = $modelExperiencia->getExperienciaPorId($id);
        $form->populate($experiencia);
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParams();
            $data['idDetalleEmpresa'] = $id;
            //if ($form->isValid($data)) {                
            $id = $modelExperiencia->actualizarDatos($data);
            $this->_flashMessenger->addMessage("Experiencia Laboral modificada con éxito");
            $this->_redirect('/admin/consorcio/personal-explaboral/id/'.$personal.'/empresa/'.$idempresa);

            /* } else {
              $form->populate($data);
              } */
        }
        $this->view->form = $form;
    }
        
    public function personalDetaEstudioAction() {
        $idPersonal = $this->_getParam("id");
        $empresa = $this->_getParam("empresa");
        if ($idPersonal) {
            $modelExperiencia = new App_Model_Experiencia();
            $listaExperiencia = $modelExperiencia->listarExperiencia(NULL, $idPersonal);
            $this->view->listaExperiencia = $listaExperiencia;
            $this->view->empresa = $idPersonal;
            $this->view->personal = $empresa;
        } else {
            $this->_redirect('/admin/consorcio');
        }
    }
    
}

