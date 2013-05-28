<?php

class Admin_SubespecialidadController extends App_Controller_Action_Admin
{

    public function init()
    {
        parent::init();
    }
    
    public function subEspecialidadAjaxAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();        
        $id = $this->_getParam('id');
        $modelEspe = new App_Model_SubEspecialidad();
        $result = $modelEspe->getSubEspecialidad($id);
        
        $rs = array();
        foreach ($result as $item) {
            $objCategorias = new stdClass();
            $objCategorias->$item['idSubEspecialidad'] = $item['descripcion'];
            $rs[] = $objCategorias;
        }

        echo Zend_Json::encode($rs);
        
        //echo Zend_Json::encode($result);
    }
    

}

