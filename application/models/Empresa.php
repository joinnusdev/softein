<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_Empresa extends App_Db_Table_Abstract {

    protected $_name = 'empresa';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const ESTADO_PORCONFIRMAR = 2;
    const TABLA_EMPRESA = 'empresa';
    const TIPO_EMAIL = 1;
    const VERIFICAR_ESTADO = 2;
    const TIPO_ADMIN = 1;
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    public function loguinUsuario($username, $passwordIng, $tipoUsuario)
    {   

        Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

        try {
            
            $db = $this->_db;
            $adapter = new Zend_Auth_Adapter_DbTable($db);
            $adapter->setTableName(self::TABLA_EMPRESA)
                ->setIdentityColumn('email')
                ->setCredentialColumn('clave')
                ->setCredentialTreatment('md5(?)')
                ->setIdentity($username)
                ->setCredential($passwordIng);
            
            $adapter->getDbSelect()
                ->where('tipoUsuario = ?', $tipoUsuario);
            //    ->where('estado = ?', self::ESTADO_ACTIVO)
            

            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
            
            if ($result->isValid()) {                
               
              $data = $adapter->getResultRowObject();
                $auth->getStorage()->write($data);
                
                $dataAcceso = array(
                    'idEmpresa' => $data->idEmpresa,
                    'ultimaIp' => $this->_getRealIP(),
                    'fechaUltimoAcceso' => Zend_Date::now()->toString('Y-MM-d HH:mm:ss')
                );

                $this->actualizarDatos($dataAcceso);
                return true;
                
            } else {
                $auth->clearIdentity();
                return false;
            }
        } catch (Zend_Exception $e) {
            $mens = "Auth" . $e->getMessage() . ' - ' . $e->getTraceAsString();
            Zend_Registry::get('log')->log($mens, Zend_Log::CRIT);
            return false;
        }
    }
    
    
    private function _guardar($datos, $condicion = NULL) {
       
        $id = 0;
        if (!empty($datos['idEmpresa'])) {
            $id = (int) $datos['idEmpresa'];
        }
        unset($datos['idEmpresa']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
              echo  $condicion = ' AND ' . $condicion;
              exit;
            }

           $cantidad = $this->_db->update(self::TABLA_EMPRESA, $datos, 'idEmpresa= ' . $id . $condicion);
         
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->_db->insert(self::TABLA_EMPRESA, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function insertEmpresa($data){
       $idUS = $this->insert($data);
       return $idUS;
       
    }
    
    public function listarUsuario() 
    {
        $query = $this->_db
                ->select()->from(array('e' => $this->_name))
                ->where('u.estado = ?', App_Model_Usuario::ESTADO_ACTIVO)
                ->where('u.tipoUsuario = ?', App_Model_Usuario::TIPO_ADMIN)
                ->limit(50);

        return $this->_db->fetchAll($query);
    }
    
    public function getEmpresaPorId($id, $tipo = NULL) 
    {
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('idEmpresa = ?', $id);
        if ($tipo)
            $query->where ('idTipoUsuario = ?', $tipo);
        
        return $this->_db->fetchRow($query);
    }
    
    
    public function getValidarEmpresaLogin($dato,$tipo) 
    {
         $query = $this->_db->select()
                ->from($this->_name);
              
            if ($tipo == 1){ //email
                $query->where ('email = ?', $dato);
                 
            }
            if ($tipo == 2){ //estado usuario
                $query->where ('idEmpresa = ?', $dato);
            }
            
     
        return $this->_db->fetchRow($query);
    }
    
    
     
    public function _getRealIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
                return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }
    
    public function getConsorciosEmpresa($idEmpresa) 
    {
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('consorcio = ?', $idEmpresa);
        
        return $this->_db->fetchAll($query);
    }
    
    
    
   
   
}

