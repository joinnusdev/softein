<?php

class Admin_ProcesosController extends App_Controller_Action_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        
    }
    
    public function criteriosSeleccionAction(){
        $model= new App_Model_Procesos();
        $lista = $model->listarCriterios();
        $this->view->listaCriterio = $lista;
    }
    
    public function criteriosSeleccionCrearAction(){
        
         
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        ); 
        
        $form = new App_Form_CriteriosSeleccion();
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){         
            $data = $this->getRequest()->getPost();
            $modelProceso = new App_Model_Procesos();
            /*
            $seleccion = $modelProceso->getCriterioPorId($data['idConvocatoria']);
            if(count($seleccion)>0){
                $this->_flashMessenger->addMessage("La convocatoria ya tiene criterios de selección");
                $this->_redirect('/admin/procesos/criterios-seleccion/');
                exit;
            }
            */
            if ($form->isValid($data)) {
                $model = new App_Model_Procesos();
                $data['idConvocatoria'] = $data['idConvocatoria'];
                $data['experienciaEspecificaAnos'] = $data['experienciaEspecificaAnos'];
                $data['experienciaEspecificaAnos'] = $data['experienciaEspecificaAnos'];
                
                $data['experienciaGeneralAnos'] = $data['experienciaGeneralAnos'];
                $data['experienciaGeneralAnos'] = $data['experienciaGeneralAnos'];
                print_r($data);
                $id = $model->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Criterios Grabados");
                $this->_redirect('/admin/procesos/criterios-seleccion/');
                
            } /*else {
                $form->populate($data);                
            }*/
        }
        
    }
    
    public function criteriosSeleccionEditarAction(){
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        ); 
        
        $modelProceso = new App_Model_Procesos();
        $form = new App_Form_CriteriosSeleccion();
        $id = $this->_getParam('id');
        $seleccion = $modelProceso->getCriterioPorId($id);
        $form->populate($seleccion);        
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();            
            $data['idCriterio'] = $id;
            if ($form->isValid($data)) {                
                $id = $modelProceso->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Criterio de Selección Actualizado");
                $this->_redirect('/admin/procesos/criterios-seleccion');
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
        
    }
    
    public function criteriosSeleccionEliminarAction()
    {        
        $model = new App_Model_Procesos();
        $idSeleccion = $this->_getParam('id');
        $model->eliminarCriterioSeleccion($idSeleccion);
        $this->_flashMessenger->addMessage("Criterio de Selección Eliminada");
        $this->_redirect('/admin/procesos/criterios-seleccion/');
    }
    
    /* CRITERIOS DE EVALUACION */
    
    public function criteriosEvaluacionPersonalAction(){
        $model= new App_Model_CriterioEvaluacion();
        $idEvaluacion = $this->_getParam('id');
        $lista = $model->listarCriteriosEvaluacion($idEvaluacion);
        $this->view->idEvaluacion = $idEvaluacion;
        $this->view->listaCriterioEvaluacion = $lista;
        
    }
    
    public function criteriosEvaluacionCrearAction(){
        
    $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/admin/personal.js'
        );
        
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        ); 
        $idEvaluacion = $this->_getParam('id');
        $this->view->idEvaluacion = $idEvaluacion;
        
        $form = new App_Form_CriteriosEvaluacion();
        $this->view->form = $form;
        
        if($this->getRequest()->isPost()){            
            $id = $this->_getParam('id');
            $data = $this->getRequest()->getPost();
            
            if ($form->isValid($data)) {
                $model = new App_Model_CriterioEvaluacion();
                $data['idCriterio'] = $id;
                $profesion = $data['idProfesion'];
                $especialidad = $data['idEspecialidad'];
                unset ($data['idProfesion']);
                unset ($data['idEspecialidad']);
                
                $idce = $model->actualizarDatos($data);                
                // detalle profesion                
                $modeldp = new App_Model_DetaProfesion();                
                for ($i=0;$i < count($profesion);$i++) {
                    $prof = array(
                        'idCriterioEvaluacion' => $idce,
                        'idProfesion'          => $profesion[$i],
                    );
                    $modeldp->actualizarDatos($prof);
                }                
                // detalle especialidad
                $modelde = new App_Model_DetaEspecialidad();
                for ($i=0;$i < count($especialidad);$i++) {
                    $esp = array(
                        'idCriterioEvaluacion' => $idce,
                        'idEspecialidad'       => $especialidad[$i],
                    );
                $modelde->actualizarDatos($esp);
                }
                $this->_flashMessenger->addMessage("Criterios de Evaluación Creada");
                $this->_redirect('/admin/procesos/criterios-evaluacion-personal/id/'.$idEvaluacion);
                
            } else {
                $form->populate($data);
            }
        }
    }
    
    public function criteriosEvaluacionEditarAction(){
         $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/admin/personal-editar.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        ); 
        
        $idx = $this->_getParam('id');
        $this->view->idEvaluacion = $idx;
        
        $modelEvaluacion = new App_Model_CriterioEvaluacion();
        $form = new App_Form_CriteriosEvaluacion();
        
        $idEvaluacion = $this->_getParam('idEvaluacion');
        
        $evalucion = $modelEvaluacion->getCriterioEvaluacionPorId($idEvaluacion);
        
        $modeldetapro = new App_Model_DetaProfesion();
        $detaprofe = $modeldetapro->getDetaProfesion($idEvaluacion);
                
        $modeldetaesp = new App_Model_DetaEspecialidad();
        $detaespe = $modeldetaesp->getDetaEspecialidad($idEvaluacion);
        
        $modelSubEsp = new App_Model_SubEspecialidad();
        if ($detaespe){
        $opt = $modelSubEsp->getSubEspecialidadCombo($detaespe);
        $form->idSubEspecialidad->setMultiOptions($opt);
        }
        $form->populate($evalucion);
        $form->idProfesion->setValue($detaprofe);
        
        $modelEsp = new App_Model_Especialidad();  
        if ($detaprofe){
        $options = $modelEsp->getEspecialidadArray($detaprofe);
        $form->idEspecialidad->setMultiOptions($options);
        $form->idEspecialidad->setValue($detaespe);
        }
        
        
        
        
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();            
            $data['idCriterioEvaluacion'] = $idEvaluacion;
            if ($form->isValid($data)) {
                $data['idCriterio'] = $idx;
                $model = new App_Model_CriterioEvaluacion();
                $profesion = $data['idProfesion'];
                $especialidad = $data['idEspecialidad'];
                unset ($data['idProfesion']);
                unset ($data['idEspecialidad']);
                
                $idce = $model->actualizarDatos($data);
                // detalle profesion                
                $modeldp = new App_Model_DetaProfesion();                
                for ($i=0;$i < count($profesion);$i++) {
                    $prof = array(
                        'idCriterioEvaluacion' => $idEvaluacion,
                        'idProfesion'          => $profesion[$i],
                    );
                    $modeldp->actualizarDatos($prof);
                }                
                // detalle especialidad
                $modelde = new App_Model_DetaEspecialidad();
                for ($i=0;$i < count($especialidad);$i++) {
                    $esp = array(
                        'idCriterioEvaluacion' => $idEvaluacion,
                        'idEspecialidad'       => $especialidad[$i],
                    );
                $modelde->actualizarDatos($esp);
                }
                
//                $id = $modelEvaluacion->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Criterio de Evaluación Actualizado");
                $this->_redirect('/admin/procesos/criterios-evaluacion-personal/id/'.$idx);
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
        
    }
    
     public function criteriosEvaluacionEliminarAction()
    {        
        $model = new App_Model_CriterioEvaluacion();
        $id = $this->_getParam('id');
        $idEvaluacion = $this->_getParam('idEvaluacion');
        $model->eliminarCriterioEvaluacion($idEvaluacion);
        $this->_flashMessenger->addMessage("Criterio de Evaluacion Eliminada");
        $this->_redirect('/admin/procesos/criterios-evaluacion-personal/id/'.$id);
    }
    
    public function evaluarConvocatoriaAction(){
        
    }
}

