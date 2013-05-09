<?php

class Admin_RegistroController extends App_Controller_Action_Admin
{

    public function init()
    {
        parent::init();
        /* Initialize action controller here */        
    }
    
    public function indexAction()
    {  
      $this->_helper->layout->setLayout('login');
        
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/lib/jquery.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/form/jquery.validate.js'
        );
        
        $form = new App_Form_Registro();
        $this->view->form = $form;
        $form->paisEmpresa->setValue("173");
         if($this->getRequest()->isPost()){
            $modelEmpresa = new App_Model_Empresa();
            $data = $this->getRequest()->getPost();
            
            $validarEmail = $modelEmpresa->getValidarEmpresaLogin($data['email'],  App_Model_Empresa::TIPO_EMAIL);
           
            if ($validarEmail['email'] == $data['email']) {
                $this->_flashMessenger->addMessage("Email ya esta registrado");
                
                $this->_redirect($this->view->url(array("module" => "admin",
                "controller" => "auth",
                "action" => "index")));
            }else{
                if ($form->isValid($data)) {
                   
                    $caracteres = 15;
                    $random = substr(md5(rand()), 0, $caracteres); 
                    
                    
                  $modelEmpresa = new App_Model_Empresa();
                    $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                    $data['fechaRegistro'] = $fechaRegistro;
                    $data['estado'] = App_Model_Empresa::ESTADO_PORCONFIRMAR;
                    $data['clave'] = md5($data['clave']);
                    $data['confirmar'] = $random;
                    $data['tipoUsuario'] = '1' ;
                    
                    $id = $modelEmpresa->insertEmpresa($data);
                    
                    //$host  = $_SERVER['SERVER_NAME'];
                    
                    $ruta = 'http://sigece.softein.com/admin/registro/confirmar-registro/usuario/'.$id.'/hash/'.$random;
                    
                  /*
                  try {
                        $mail = new Zend_Mail();
                        $html = "<b>Aca va todo el html</b></br><h1>NUEVO</h1>";
                        $mail->setBodyHtml($html);
                        $mail->setFrom('jsteve.villano@gmail.com', 'Softein');
                        $mail->addTo('jsteve.villano@gmail.com','john');
                        $mail->setSubject('titulo del mensaje');
                        $mail->send();
                    } catch (Zend_Exception $e) {
                        var_dump($e->getMessage());
                    }
                    echo "se envio correo";
                    //exit;
                    */
            
                    $to      = $data['email'];
                    $subject = 'Registro en aplicativo SIGECE para consultorías de firma';        

                    $message = '
                         <html>
                                <body>
                                    Estimados Sres. '. $data["nombreEmpresa"] .', 
                                    su registro de datos generales ha sido recibido. <p>
                                    Para activar su cuenta haga click 
                                    <a href='.$ruta.'>
                                        Aquí
                                    </a>
                                </body>
                        </html>
                                ';

                    $header="From: comunica@sigece.softein.com"."\nReply-To:comunica@sigece.softein.com"."\n"; 
                    $header=$header."X-Mailer:PHP/".phpversion()."\n"; 
                    $header=$header."Mime-Version: 1.0\n"; 
                    $header=$header."Content-Type: text/html; charset=utf-8\n";

                    mail($to, $subject, $message, $header);
                    
                    $this->_flashMessenger->addMessage("
                    Verifique su cuenta de correo ". $data['email'] ." que contiene un mensaje con un link de
                    activacion para su cuenta. <p> Si el mensaje tardara mucho en llegar o no lo
                    visualiza verifique su carpeta de correos spam.
                    Se le envió un correo para confirmar su registro.");
                    $this->_redirect('/admin/auth');
                }else{
                    $this->_flashMessenger->addMessage("Ocurrio un error");
                    $this->_redirect('/admin/auth');

                }
            }  
            
        }else{
            
            echo "sss";
        }
        
    }
    
    
    public function confirmarRegistroAction(){
            $this->_helper->layout->setLayout('login');
            //$ruta = 'admin/registro/confirmar-registro/usuario/'.$id.'/hash/'.$random;
        if ($this->_request->getParam('hash') != '') {
            $modelEmpresa = new App_Model_Empresa();
            
            $dato = $modelEmpresa->getEmpresaPorId($this->_getParam('usuario'));
            
            if ($dato['confirmar'] == $this->_request->getParam('hash')) {
               
                $data['idEmpresa'] = $this->_request->getParam('usuario');
                $data['confirmar'] = '';
                $data['estado'] = App_Model_Empresa::ESTADO_ACTIVO;
                
                $id = $modelEmpresa->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Su cuenta ha sido activada puede Iniciar Sesión");
                $this->_redirect('/admin/auth');
                
            } else {
                $this->_flashMessenger->addMessage("El código de activacion es diferente o ya expiro");
                $this->_redirect('/admin/auth');
            }
        }else{
            $this->_flashMessenger->addMessage("No es posible la validacion");
            $this->_redirect('/admin/auth');
        }
            
    }
  

}

