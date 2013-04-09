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
                   
                    /*
                    $modelEmpresa = new App_Model_Empresa();
                    $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                    $data['fechaRegistro'] = $fechaRegistro;
                    $data['estado'] = App_Model_Empresa::ESTADO_PORCONFIRMAR;
                    $data['clave'] = md5($data['clave']);
                    $id = $modelEmpresa->actualizarDatos($data);
                    */
                     //Configuración SMTP
                    $host = 'smtp.gmail.com';
                    $param = array(
                    'auth' => 'login',
                    'ssl' => 'ssl',
                    'port' => '465',
                    'username' => 'steve.villano@codesystemdevelopers.com',
                    'password' => 'prueba*123'
                    );
                    $tr = new Zend_Mail_Transport_Smtp($host, $param);
                    Zend_Mail::setDefaultTransport($tr);
                    
                    $caracteres = 15;
                    $random = substr(md5(rand()), 0, $caracteres); 
                    $mail = new Zend_Mail();                    
                    $mail->setBodyHtml("contenido");
                    $mail->setFrom('steve_seven_7@hotmail.com', 'Softein');
                    $mail->addTo('jsteve.villano@gmail.com');
                    $mail->setSubject('Confirma tu registro - AlertaMovil');
                    $mail->send();
                    
                    
                    
                    
                    $this->_flashMessenger->addMessage("Se le envió un correo para confirmar su Registro");
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
    }
  

}

