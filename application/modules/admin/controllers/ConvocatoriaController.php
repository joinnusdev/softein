<?php

class Admin_ConvocatoriaController extends App_Controller_Action_Admin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $model = new App_Model_Convocatoria();
        $idEmpresa = $this->view->authData->idEmpresa;
        $lista = $model->listarConvocatoria($idEmpresa);
        $this->view->lista = $lista;
    }
    
    public function paso2Action() { 
        
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js2/admin/agregar-personal.js'
        );
        $idEmpresa = $this->view->authData->idEmpresa;
        $modelPersonal = new App_Model_Personal();        
        $this->view->personal = $modelPersonal->listarPersonal($idEmpresa);        
        $idConvocatoria = $this->_getParam('id');
        
        
        $modelConv = new App_Model_ConvocatoriaEmpresa();
        
        $convEmpresa = $modelConv->getConvocatoriaEmpresa($idConvocatoria, $idEmpresa);                

        
        if ($this->_request->isPost()) {
            $data = $this->_getAllParams();
            $modelDeta = new App_Model_DetaPersonal();
            $personal = array_unique($data['personal']);            
            for ($i = 0; $i < count($personal); $i++){
                $datosDeta = array(
                    'idConvocatoriaExperiencia' => $convEmpresa['idConvocatoriaExperiencia'],
                    'idPersonal' => $personal[$i],
                );                
                $modelDeta->actualizarDatos($datosDeta);                                
            }
            $mail = $this->view->authData->email;
            $name = $this->view->authData->nombreEmpresa;
            $subject = "Convocatoria Registrada";
            $htmlbody = "
                
            <!DOCTYPE html>
            <html lang='en'>
                <head> <title>Email Convocatoria</title>
                </head>
                <body>
                <table>
                <tr>
                    <td>Código Autogenerado :</td>
                    <td> " . $convEmpresa['codigo'] . " </td>
                </tr>
                <tr>
                    <td>Empresa :</td>
                    <td> " . $this->view->authData->nombreEmpresa . " </td>
                </tr>
                <tr>
                    <td>Convocatoria :</td>
                    <td> " . $convEmpresa['proceso'] . " </td>
                </tr>
                <tr>
                    <td>Código Proceso :</td>
                    <td> " . $convEmpresa['codigoproceso'] . " </td>
                </tr>
                <tr>
                    <td>Fecha Limite :</td>
                    <td> " . $convEmpresa['limite'] . " </td>
                </tr>
                
                <tr>
                    <td colspan='2'> TEXTO POR DEFINIR</td>
                </tr>
                

                </table>
                </body>
                </html>
                ";
            Extra_Utils::enviarMail($mail, $name, $subject, $htmlbody);
            
            
            $this->_flashMessenger->addMessage("Convocatoria Registrada Correctamente");
            $this->_redirect('/admin/convocatoria');
            
        }
        
        $this->view->convocatoria = $convEmpresa;
        
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
                
                $idEmpresa = $this->view->authData->idEmpresa;
                $codigo = $idConvocatoria . "-" . $idEmpresa . "-" . $this->stringAleatorio();
                
                $datos = array(
                    'idConvocatoria' => $idConvocatoria,
                    'codigo' => $codigo,
                    'fechaRegistro' => Zend_Date::now()->toString('Y-M-d HH:mm:ss'),
                    'idEmpresa' => $idEmpresa,
                    'estado' => '2',
                    );
                $modelConvocatoria = new App_Model_ConvocatoriaEmpresa();
                $id = $modelConvocatoria->actualizarDatos($datos);
                
                $modelDetaExp = new App_Model_DetaExperiencia();
                
                for ($i = 0; $i < count($session->experiencia); $i++){
                    
                    $exp = $data['experiencia'][$i];
                    $dataDetalle = array(
                        'idConvocatoriaExperiencia' => $id,
                        'idExperiencia' => $exp,                    
                    );                    
                    $modelDetaExp->actualizarDatos($dataDetalle);                    
                }
                
                
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
    
    function stringAleatorio($length = 3) {
        $source = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if ($length > 0) {
            $rstr = "";
            $source = str_split($source, 1);
            for ($i = 1; $i <= $length; $i++) {
                mt_srand((double) microtime() * 1000000);
                $num = mt_rand(1, count($source));
                $rstr .= $source[$num - 1];
            }
        }
        return $rstr;
    }
    
    public function paso1EditAction() {
        $idConvocatoria = $this->_getParam('id');
        // datos de la convocatoria
        $modelCon = new App_Model_Convocatoria();
        $this->view->convocatoria = $modelCon->getConvocatoriaPorId($idConvocatoria);
        
        //datos de las experiencias registradas
        $modelConEmp = new App_Model_ConvocatoriaEmpresa();
        $this->view->exp = $modelConEmp->getExperienciaDeta($idConvocatoria);
        
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
                
                $idEmpresa = $this->view->authData->idEmpresa;
                $convexp = $modelConEmp->getConvocatoriaEmpresa($idConvocatoria, $idEmpresa);
                
                
                $modelDetaExp = new App_Model_DetaExperiencia();
                $modelDetaExp->eliminarDetalle($convexp['idConvocatoriaExperiencia']);
                for ($i = 0; $i < count($session->experiencia); $i++){                    
                    $exp = $data['experiencia'][$i];
                    $dataDetalle = array(
                        'idConvocatoriaExperiencia' => $convexp['idConvocatoriaExperiencia'],
                        'idExperiencia' => $exp,                    
                    );                    
                    $modelDetaExp->actualizarDatos($dataDetalle);                    
                }                
                
                $this->_redirect('admin/convocatoria/paso2-edit/id/' . $session->convocatoria);
            } else {
                $this->_flashMessenger->addMessage("Debe seleccionar como Mínimo una experiencia");
                $this->_redirect('admin/convocatoria/paso1-edit/id/' . $session->convocatoria);
            }
        }
    }
    
    public function paso2EditAction() { 
        
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js2/admin/editar-personal.js'
        );
        $idEmpresa = $this->view->authData->idEmpresa;
        $modelPersonal = new App_Model_Personal();        
        $this->view->personal = $modelPersonal->listarPersonal($idEmpresa);
        
        $idConvocatoria = $this->_getParam('id');
        
        
        $modelConv = new App_Model_ConvocatoriaEmpresa();
        
        $convEmpresa = $modelConv->getConvocatoriaEmpresa($idConvocatoria, $idEmpresa);
        $modelDeta = new App_Model_DetaPersonal();
        $this->view->lista = $modelDeta->listarPersonal($convEmpresa['idConvocatoriaExperiencia']);
                
        if ($this->_request->isPost()) {
            $data = $this->_getAllParams();           
            
            $personal = array_unique($data['personal']);            
            
            $modelDeta->eliminarDetalle($convEmpresa['idConvocatoriaExperiencia']);            
            
            foreach ($personal as $value) {
                $datosDeta = array(
                    'idConvocatoriaExperiencia' => $convEmpresa['idConvocatoriaExperiencia'],
                    'idPersonal' => $value,
                );                
                $modelDeta->actualizarDatos($datosDeta);                
            }
            
            // ------------------ Envio Email
            
            $mail = $this->view->authData->email;
            $name = $this->view->authData->nombreEmpresa;
            $subject = "Convocatoria Registrada";
            $htmlbody = "
                
            <!DOCTYPE html>
            <html lang='en'>
                <head> <title>Email Convocatoria</title>
                </head>
                <body>
                <table>
                <tr>
                    <td>Código Autogenerado :</td>
                    <td> " . $convEmpresa['codigo'] . " </td>
                </tr>
                <tr>
                    <td>Empresa :</td>
                    <td> " . $this->view->authData->nombreEmpresa . " </td>
                </tr>
                <tr>
                    <td>Convocatoria :</td>
                    <td> " . $convEmpresa['proceso'] . " </td>
                </tr>
                <tr>
                    <td>Código Proceso :</td>
                    <td> " . $convEmpresa['codigoproceso'] . " </td>
                </tr>
                <tr>
                    <td>Fecha Limite :</td>
                    <td> " . $convEmpresa['limite'] . " </td>
                </tr>
                
                <tr>
                    <td colspan='2'> TEXTO POR DEFINIR</td>
                </tr>
                

                </table>
                </body>
                </html>
                ";
            Extra_Utils::enviarMail($mail, $name, $subject, $htmlbody);
            
            
            
            
            // ------------------
             
              
             
             
            
            
            $this->_flashMessenger->addMessage("Convocatoria Registrada Correctamente");
            $this->_redirect('/admin/convocatoria');
            
        }
        
        $this->view->convocatoria = $convEmpresa;
        
    }

}

