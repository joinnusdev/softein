<?php

class Admin_ProcesosController extends App_Controller_Action_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $model = new App_Model_Convocatoria();
        $idEmpresa = $this->view->authData->idEmpresa;
        $lista = $model->listarConvocatoria($idEmpresa);
        $this->view->lista = $lista;
    }
    
    
    public function criteriosSeleccionAction(){
        
    }
    
    public function evaluarConvocatoriaAction(){
        
    }
}

