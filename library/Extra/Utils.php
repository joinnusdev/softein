<?php

class Extra_Utils
{    

    static function truncar($value)
    {
        return ((int) $value == (float) $value) ? (int) $value : (float) $value;
    }

    static function enviarMail($mail, $name, $subject, $htmlbody)
    {
        $correo = new Zend_Mail('utf-8');
        $correo->addTo($mail, $name)
                ->clearSubject()
                ->setSubject($subject)
                ->setBodyHtml($htmlbody);
        try {
            $correo->send();
            return true;
        } catch (Zend_Exception $e) {
            //throw new Zend_Mail_Exception($e->getMessage());
            $log = Zend_Registry::get('log');
            $log->debug("Enviar-Mail: " . $e->getMessage());
            return false;
        }
    }


    static function pdf($rpta, $flagcron = NULL)
    {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        if (null === $viewRenderer->view) {
            $viewRenderer->initView();
        }
        $view = $viewRenderer->view;
        $config = Zend_Registry::get('config');
        
        if (in_array($flagcron, array('crones', 'crontr_newpend', 'cron_conftran'))) {
            $pedidoRpta = (in_array($flagcron, array('crontr_newpend', 'cron_conftran')))
                    ? $rpta["datos_pedido"] : $rpta;
            $controller = 'pedido';
            $view->addBasePath(APPLICATION_PATH . '/modules/admin/views');
        } else {
            $pedidoRpta = $rpta["datos_pedido"];
            $controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        }
        

        $idpedido = $pedidoRpta['id'];
        $idcamp = $pedidoRpta['campana_id'];

        $cupon = new App_Model_Cupon();
        $cupones = $cupon->pdfCuponesPorIdPedido($idpedido);
        //$view->cupones = $cupon->pdfCuponesPorIdPedido($idpedido);        
        if (in_array($flagcron, array('crones', 'crontr_newpend'))) {
            $view->assign('cupones', $view->cupones);
        }
        /*sasa*/
        
        $path = APPLICATION_PATH . "/../library/MPDF56/mpdf.php";
        require_once($path);

        $mpdf=new mPDF('c', 'A4'); 
        $mpdf->SetDisplayMode('fullpage');
        $sizeFile = $config->app->sizePdf_MemoryLimit;
        ini_set("memory_limit", $sizeFile);
        
        foreach ($cupones as $valor):
            $view->cupones = $valor;
            $view->idcamp = $idcamp;
            $html = $view->render("$controller/cuponespdf.phtml");
            //$codigo = utf8_decode($html);
            $mpdf->WriteHTML($html);
            //$mpdf->AddPage();
            
        endforeach;
        
        if ($pedidoRpta['subcampana_id'] == 0)
            $prefijo = $idcamp;
        else
            $prefijo=$idcamp . '_' . $pedidoRpta['subcampana_id'];        
        $name = $prefijo . '_' . $idpedido . ".pdf";
        $ruta = APPLICATION_PATH . "/../public/html/"; 
        $mpdf->Output($name, '', $ruta);
        
        $pdf = $ruta . $name;        
        
        $ftp = new Extra_Ftp(
            $config->app->elementsUrlHost, $config->app->elementsUrlUsername, $config->app->elementsUrlPassword
        );
        $ftp->openFtp();
        $ftp->newDirectory(array('pdf'));
        $ftp->upImage($prefijo . '_' . $idpedido . ".pdf", $pdf);
        $ftp->closeFtp();
        unlink($pdf);
    }


}