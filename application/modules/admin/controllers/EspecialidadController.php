<?php

class Admin_EspecialidadController extends App_Controller_Action_Admin
{

    public function init()
    {
        parent::init();
    }
    
    public function especialidadAjaxAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();        
        $id = $this->_getParam('id');
        $modelEspe = new App_Model_Especialidad();
        $result = $modelEspe->getEspecialidadPorProfesion($id);
        
        $rs = array();
        foreach ($result as $item) {
            $objCategorias = new stdClass();
            $objCategorias->$item['idEspecialidad'] = $item['descripcion'];
            $rs[] = $objCategorias;
        }

        echo Zend_Json::encode($rs);
        
        //echo Zend_Json::encode($result);
    }
    

}

