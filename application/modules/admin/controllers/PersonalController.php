<?php

class Admin_PersonalController extends App_Controller_Action_Admin
{

    public function init()
    {
        parent::init();
    }
    
    public function indexAction()
    {
        $model= new App_Model_Personal();
        $idEmpresa = $this->view->authData->idEmpresa;
        $lista = $model->listarPersonal($idEmpresa);
        $this->view->listaExperiencia = $lista;
    }
    
    public function crearAction()
    {        
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/admin/personal.js'
        );
        
        $form = new App_Form_CrearPersonal();
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
            
            if ($form->isValid($data)) {
                $model = new App_Model_Personal();
                $data['fechaRegistro'] = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['estado'] = '1';
                $data['idEmpresa'] = $this->view->authData->idEmpresa;
                $id = $model->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Personal Creado Correctamente");
                $this->_redirect('/admin/personal');
                
            } /*else {
                $form->populate($data);                
            }*/
        }
    }
    
    public function editarAction()
    {        
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/admin/personal-editar.js'
        );
        $model = new App_Model_Personal();
        $form = new App_Form_CrearPersonal();
        $id = $this->_getParam('id');
        $personalData = $model->getPersonalPorId($id);
        
        $modelEsp = new App_Model_Especialidad();
        $espec = $modelEsp->getComboEspecialidad($personalData['idProfesion']);
                
        $modelSubEsp = new App_Model_SubEspecialidad();
        $subespec = $modelSubEsp->getComboSubEspecialidad($personalData['idEspecialidad']);
        
        
        $form->getElement('idEspecialidad')->setMultiOptions(
            array("0" => "--- Seleccionar ---")+$espec);
        $form->getElement('idSubEspecialidad')->setMultiOptions(
            array("0" => "--- Seleccionar ---")+$subespec);
        
        
        $form->populate($personalData);        
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();            
            $data['idPersonal'] = $id;
            //if ($form->isValid($data)) {                
                $id = $model->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Personal actualizado con éxito");
                $this->_redirect('/admin/personal');
                
            /*} else {
                $form->populate($data);                
            }*/
        }
        $this->view->form = $form;
    }
    
    public function eliminarAction()
    {        
        $model = new App_Model_Personal();
        $id = $this->_getParam('id');
        $model->eliminarPersonal($id);
        $this->_flashMessenger->addMessage("Personal eliminado correctamente");
        $this->_redirect('/admin/personal');
    }
    

}

