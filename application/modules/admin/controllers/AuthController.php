<?php

class Admin_AuthController extends App_Controller_Action
{

      
    public function init() {
        parent::init();
        
    }



    public function indexAction()
    {   

        $this->_helper->layout->setLayout('login');
        
        if ($this->_request->isPost()) {            
            
            $data = $this->_getAllParams();
            
            $f = new Zend_Filter_StripTags();
            
            $email = $f->filter($data['email']);
            $clave = $f->filter($data['clave']);
            /*
            $empresa = new App_Model_Empresa();
            $valido = $empresa->loguinUsuario($email, $clave, array(App_Model_Empresa::TIPO_ADMIN));
            
            if (Zend_Auth::getInstance()->hasIdentity()) {
                
                $auth = Zend_Auth::getInstance();
                $estado = $auth->getStorage()->read()->estado;
                
                 if ($estado  == App_Model_Empresa::ESTADO_PORCONFIRMAR) {
                    $this->_flashMessenger->addMessage("Su cuenta está creada pero aún no ha sido activada");
                    $this->_redirect($this->view->url(array("module" => "admin",
                    "controller" => "auth",
                    "action" => "index")));
                }else{
                        $this->_redirect($this->view->url(array("module" => "admin",
                            "controller" => "empresa",
                            "action" => "mis-datos")));
                }
                
            }
            else {
                $this->_helper->redirector->gotoUrl('/admin/');
            }
            */
             
                       
            if ($this->autentificateUser($email, $clave)) {
               
                $data = $this->getRequest()->getPost();
                
                $auth = Zend_Auth::getInstance();
                $estado = $auth->getStorage()->read()->estado;
                
                 if ($estado  == App_Model_Empresa::ESTADO_PORCONFIRMAR) {
                      $auth->clearIdentity();
                    $this->_flashMessenger->addMessage("Su cuenta está creada pero aún no ha sido activada");
                    $this->_redirect($this->view->url(array("module" => "admin",
                    "controller" => "auth",
                    "action" => "index")));
                }else{                        
                    if ($auth->getStorage()->read()->tipoUsuario == 1)
                        $this->_redirect($this->view->url(array("module" => "admin",
                                    "controller" => "empresa",
                                    "action" => "mis-datos")));
                    if ($auth->getStorage()->read()->tipoUsuario == 2)
                        $this->_redirect($this->view->url(array("module" => "admin",
                                    "controller" => "reportes")));
                        
                }
                
            }else{
                $this->_flashMessenger->addMessage("Verifique sus credenciales");
                    $this->_redirect($this->view->url(array("module" => "admin",
                    "controller" => "auth",
                    "action" => "index")));
            }
            
            
        }
    
    } 
    public function logoutAction()
    {       	
        $this->_helper->layout->disableLayout();
        
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect($this->view->url(array("module" => "admin",
                            "controller" => "auth",
                            "action" => "index")));
        
        /*
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {            
            $data = $auth->getStorage()->read();
            $auth->clearIdentity();
            $this->_redirect($this->view->url(array("module" => "admin",
                            "controller" => "auth",
                            "action" => "index")));
        } else {
            $this->_helper->redirector->gotoUrl('/admin');
        }*/

    }
    
    public function claveAction(){
     
         if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
             $modelEmpresa = new App_Model_Empresa();
            $validarEmail = $modelEmpresa->getValidarEmpresaLogin($data['email'],  App_Model_Empresa::TIPO_EMAIL);
           
           
            if ($validarEmail['email'] == $data['email']) {
                $characters = array(
                            "A","B","C","D","E","F","G","H","J","K","L","M",
                            "N","P","Q","R","S","T","U","V","W","X","Y","Z",
                            "1","2","3","4","5","6","7","8","9");

                    $keys = array();

                    while(count($keys) < 8) {
                        $x = mt_rand(0, count($characters)-1);
                        if(!in_array($x, $keys)) {
                        $keys[] = $x;
                        }
                    }

                    foreach($keys as $key){
                    $nuevaClave .= $characters[$key];
                    }
                //$new = $nuevaClave;
                $nuevaClave = '123456789';    
                $modelEmpresa = new App_Model_Empresa();
                
                $data['idEmpresa'] = $validarEmail['idEmpresa'];
                $data['clave'] = md5($nuevaClave);
                    
                $id = $modelEmpresa->actualizarDatos($data);
                    
                $ruta = 'http://sigece.softein.com/admin/registro/confirmar-registro/usuario/'.$id.'/hash/'.$random;
                $to      = $data['email'];
                $subject = 'Nueva clave - SIGECE consultorías de firma';        

                $message = '
                         <html>
                                <body>
                                    Estimados Sres. '. $validarEmail["nombreEmpresa"] .', 
                                   Su nuevo clave es el siguiente. <p>
                                    '.$nuevaClave.' 
                                    <p>
                                    Ya puede Ingresar a SIGECE y poder cambiar su Clave.
                                </body>
                        </html>
                                ';

                    $header="From: comunica@sigece.softein.com"."\nReply-To:comunica@sigece.softein.com"."\n"; 
                    $header=$header."X-Mailer:PHP/".phpversion()."\n"; 
                    $header=$header."Mime-Version: 1.0\n"; 
                    $header=$header."Content-Type: text/html; charset=utf-8\n";

                    mail($to, $subject, $message, $header);
                    
                    $this->_flashMessenger->addMessage("
                    Verifique su cuenta de correo ". $data['email'] ." que contiene un mensaje con su nuevo password.");
                    $this->_redirect('/admin/auth');
                
              
            }else{
                    $this->_flashMessenger->addMessage("Email no existe");
                
                $this->_redirect($this->view->url(array("module" => "admin",
                "controller" => "auth",
                "action" => "index")));
            }
                
            }  
            
        
        
    }

}

