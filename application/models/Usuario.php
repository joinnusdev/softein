<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_Usuario extends App_Db_Table_Abstract {

    protected $_name = 'usuario';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_USUARIO = 'usuario';
    const TIPO_CLIENTE = 2;
    const TIPO_ADMIN = 1;
    
    public function loguinUsuario($username, $passwordIng, $tipoUsuario)
    {   

        Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

        try {
            
            $db = $this->getAdapter();
            $adapter = new Zend_Auth_Adapter_DbTable($db);
            $adapter->setTableName(self::TABLA_USUARIO)
                ->setIdentityColumn('email')
                ->setCredentialColumn('clave')
                ->setCredentialTreatment('md5(?)')
                ->setIdentity($username)
                ->setCredential($passwordIng);
            
            $adapter->getDbSelect()
                ->where('tipoUsuario = ?', $tipoUsuario)
                ->where('estado = ?', self::ESTADO_ACTIVO);
            

            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
            
            

            if ($result->isValid()) {                
                $data = $adapter->getResultRowObject(null, 'clave');
                $auth->getStorage()->write($data);

                $dataAcceso = array(
                    'id' => $data->idusuario,
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
        if (!empty($datos['idusuario'])) {
            $id = (int) $datos['idusuario'];
        }
        unset($datos['idusuario']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'idusuario = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarUsuario() 
    {
        $query = $this->getAdapter()
                ->select()->from(array('u' => $this->_name))
                ->where('u.estado = ?', App_Model_Usuario::ESTADO_ACTIVO)
                ->where('u.tipoUsuario = ?', App_Model_Usuario::TIPO_ADMIN)
                ->limit(50);

        return $this->getAdapter()->fetchAll($query);
    }
    
    public function getUsuarioPorId($id, $tipo = NULL) 
    {
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('idUsuario = ?', $id);
        if ($tipo)
            $query->where ('idTipoUsuario = ?', $tipo);
        
        return $this->getAdapter()->fetchRow($query);
    }
    
    public function _getRealIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
                return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }
    
    
    
   
   
}
