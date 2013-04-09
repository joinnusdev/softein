<?php

class Extra_Plugin_Acl
        extends Zend_Controller_Plugin_Abstract
{

    private $_noauth = array('module' => 'auth',
        'controller' => 'index',
        'action' => 'login');
    
    private $_exception = array(
        'mvc:auth/index/sinacceso',      
        'mvc:auth/index/logout',
        'mvc:auth/index/login',
        );
    
    private $_noacl = array('module' => 'admin',
        'controller' => 'index',
        'action' => 'index');
    protected $_acl;
    
    protected $_role;
    
    private $_module;
    
    private $_controller;
    
    private $_action;

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {        
        
        $this->_module =  $request->getModuleName();
        $this->_controller =  $request->getControllerName();
        $this->_action =  $request->getActionName();
        
        //$this->setAcl(Zend_Registry::get('Acl'));	
        $auth = Zend_Auth::getInstance();        
        
        if ($auth->hasIdentity()) {

            $user = (object)$auth->getStorage()->read();
            
            $tipoUsuario = $user->tipoUsuario;
            $module = $this->_module;
            
            if ($tipoUsuario == 1) {
                if ($module == "admin") {
                    $request->setModuleName("admin");
                    $request->setControllerName($this->_controller);
                    $request->setActionName($this->_action);
                    return;
                }
                
            }
            if ($tipoUsuario == 2) {
                if ($module != "admin") {
                    $request->setModuleName("default");
                    $request->setControllerName("index");
                    $request->setActionName("index");
                    return;
                } else {
                    $request->setModuleName($module);
                    $request->setControllerName($this->_controller);
                    $request->setActionName($this->_action);
                    return;
                }
            }
        } else { 
            
            if ($this->_module == 'admin') {                
                $request->setModuleName('admin');
                $request->setControllerName('auth');
                $request->setActionName('index');
                return;
            } else {                
                $request->setModuleName('/');
                return;
            }
            
        }
        
    }

    /*function isValidUrl(Zend_Controller_Request_Abstract $request)
    {
        
        $acl = $this->getAcl();
        //var_dump($acl);exit;
        $url1 = 'mvc:' . $request->getModuleName() . '/*';
        $url2 = 'mvc:' . $request->getModuleName() . '/' . $request->getControllerName() . '/*';
        $url3 = 'mvc:' . $request->getModuleName() . '/'
                . $request->getControllerName() . '/' . $request->getActionName();
        return $acl->has($url1) && $acl->isAllowed($this->getRole(), $url1)
                || $acl->has($url2) && $acl->isAllowed($this->getRole(), $url2)
                || $acl->has($url3) && $acl->isAllowed($this->getRole(), $url3);
    }*/

    function getAcl()
    {
        return $this->_acl;
    }

    function getRole()
    {
        return $this->_role;
    }

    function setRole($role)
    {
        $this->_role = $role;
    }

    function setAcl($acl)
    {
        $this->_acl = $acl;
    }

}
