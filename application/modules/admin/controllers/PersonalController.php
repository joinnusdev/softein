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
        $model = new App_Model_Personal();
        $form = new App_Form_CrearPersonal();
        $id = $this->_getParam('id');
        $experiencia = $model->getPersonalPorId($id);
        $form->populate($experiencia);        
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

