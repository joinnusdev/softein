<?php

class Admin_ConvocatoriaController extends App_Controller_Action_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $model = new App_Model_Convocatoria();
        $lista = $model->listarConvocatoria();
        $this->view->lista = $lista;
    }
    
    public function paso2Action() { 
        $model = new App_Model_Convocatoria();
        $lista = $model->listarConvocatoria();
        $this->view->lista = $lista;
    }

    public function paso1Action() {
        $idConvocatoria = $this->_getParam('id');
        $modelCon = new App_Model_Convocatoria();
        $this->view->convocatoria = $modelCon->getConvocatoriaPorId($idConvocatoria);
        
        
        $session = new Zend_Session_Namespace('registro');
        $session->convocatoria = $idConvocatoria;

        $this->view->empresa = $this->view->authData;


        $modelExperiencia = new App_Model_Experiencia();
        $this->view->experiencia = $modelExperiencia->listarExperiencia(
                $this->view->authData->idEmpresa
        );
        if ($this->_request->isPost()) {
            $data = $this->_getAllParams();
            if (isset($data['experiencia'])) {
                $session->experiencia = $data['experiencia'];
                $this->_redirect('admin/convocatoria/paso2/id/' . $session->convocatoria);
            } else {
                $this->_flashMessenger->addMessage("Debe seleccionar como Mínimo una experiencia");
                $this->_redirect('admin/convocatoria/paso1/id/' . $session->convocatoria);
            }
        }
    }

    public function crearAction() {
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

    public function editarAction() {
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

