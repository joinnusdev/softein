<?php

class Admin_ReportesController extends App_Controller_Action_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js2/admin/reporte.js'
        );
        $model = new App_Model_Convocatoria();
        $lista = $model->listarConvocatoria();
        $this->view->lista = $lista;
    }
    public function convocatoriaActivaAction() {        
        $model = new App_Model_Convocatoria();
        $lista = $model->reporteConvocatoria(1);
        $this->view->lista = $lista;
    }
    
    public function convocatoriaInactivaAction() {
        $model = new App_Model_Convocatoria();
        $lista = $model->reporteConvocatoria(2);
        $this->view->lista = $lista;
    }
    public function modificarPlazoAction() {
        $model = new App_Model_Convocatoria();
        $lista = $model->reporteConvocatoria();
        $this->view->lista = $lista;
    }
    
    public function imprimirAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $path = APPLICATION_PATH . "/../library/dompdf/dompdf_config.inc.php";
        require_once($path);
        
        $idEmpresa = $this->_getParam("empresa");
        $idConvocatoria = $this->_getParam("convocatoria");
        
        //Datos Empresa y Convocatoria 
        $modelCon = new App_Model_ConvocatoriaEmpresa();
        $convEmpresa = $modelCon->getConvocatoriaEmpresa($idConvocatoria, $idEmpresa);
        
        $this->view->empresa = $convEmpresa;
        
        
        //Detalle Personal que ponen
        $model = new App_Model_DetaPersonal();
        $personal = $model->getConvocatoriaPersonal($convEmpresa['idConvocatoriaExperiencia']);
        $this->view->personal = $personal;
        // Detalle de las experiencias
        $modelExp = new App_Model_DetaExperiencia();
        $exper = $modelExp->getExperienciaEmpresa($idEmpresa, $idConvocatoria);
        $this->view->exp = $exper;
        
        $html = $this->view->render('/reportes/imprimir.phtml');
        
        $codigo = $html; 
        $dompdf = new DOMPDF();
        $dompdf->load_html($codigo);
        $dompdf->render();
        $dompdf->stream("convocatoria.pdf", array("Attachment" => 0));


        exit;
    }
    
    public function ajaxListarEmpresasAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $idConvocatoria = $this->_getParam("id");
        
        $modelConv = new App_Model_ConvocatoriaEmpresa();        
        $convEmpresa = $modelConv->getConvocatoriaEmpresa($idConvocatoria);
        echo Zend_Json::encode($convEmpresa);
        
    }

    public function evaluarAction(){
         $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js2/admin/reporte.js'
        );
        $model = new App_Model_Convocatoria();
        $lista = $model->listarConvocatoria();
        $this->view->lista = $lista;
    }
    public function imprimir2Action(){
       $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $path = APPLICATION_PATH . "/../library/dompdf/dompdf_config.inc.php";
        require_once($path);
        
          if($this->getRequest()->isPost()){            
                $data = $this->getRequest()->getPost();
                $modelConv = new App_Model_ConvocatoriaEmpresa();        
                $convEmpresa = $modelConv->getConvocatoriaEmpresa($data['convocatoria']);
                $this->view->empresas = $convEmpresa;
          
                $modelCriterioSeleccion = new App_Model_Procesos();
                $this->view->criterioEvaluacion = $modelCriterioSeleccion->getCriterioSeleccionConvocatoria($data['convocatoria']);
                
                
                $idEmpresa = 1 ; //$this->_getParam("empresa");
                $idConvocatoria = 261; //$this->_getParam("convocatoria");

                //Datos Empresa y Convocatoria 
                $modelCon = new App_Model_ConvocatoriaEmpresa();
                $convEmpresa = $modelCon->getConvocatoriaEmpresa($idConvocatoria, $idEmpresa);

                $this->view->empresa = $convEmpresa;


                //Detalle Personal que ponen
                $model = new App_Model_DetaPersonal();
                $personal = $model->getConvocatoriaPersonal($convEmpresa['idConvocatoriaExperiencia']);
                $this->view->personal = $personal;
                // Detalle de las experiencias
                $modelExp = new App_Model_DetaExperiencia();
                $exper = $modelExp->getExperienciaEmpresa($idEmpresa, $idConvocatoria);
                $this->view->exp = $exper;

                $html = $this->view->render('/reportes/imprimir2.phtml');

                $codigo = $html; 
                $dompdf = new DOMPDF();
                $dompdf->load_html($codigo);
                $dompdf->render();
                $dompdf->stream("convocatoria.pdf", array("Attachment" => 0));


                exit; 


                
           }
        
        
        
    }
    
    
}

