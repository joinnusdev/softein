<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_Convocatoria extends App_Db_Table_Abstract {

    protected $_name = 'pmsj_convoca';    
    
    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TIPO_CONVOCATORIA = '2';
    const TABLA_CONVOCATORIA = 'pmsj_convoca';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    private function _guardar($datos, $condicion = NULL) {
        Zend_Db_Table::setDefaultAdapter('db');
        $db = $this->_db;
        $where = $db->quoteInto('ID = ?', $datos['ID']);

        $db->delete($this->_name, $where);        
        $id = $db->insert($this->_name, $datos);
     
     return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarConvocatoria($idEmpresa = NULL)
    {   
        $fecha = Zend_Date::now()->toString('Y-MM-dd HH:mm:ss');
        
        $this->_updateDB($fecha);
        
        $db = $this->_db;

        $select = $db->select()
                ->from(array('c' => $this->_name));
            
        if ($idEmpresa){
                $select->joinLeft(array('ce' => App_Model_ConvocatoriaEmpresa::TABLA_EMPRESA), 
                        'c.ID = ce.idConvocatoria AND ce.idEmpresa= ' . $idEmpresa , 
                        array(
                            'est' =>'estado',
                            'empresa' => 'idEmpresa'
                            ));
        }
        $select->where('CONCAT(c.limite," ",c.hora_lim) >= ?', $fecha)
                ->where('c.estado = ?', self::ESTADO_ACTIVO)
                ->where('c.tipo = ?', self::TIPO_CONVOCATORIA)
                ->group('c.ID')
                ->order('c.fecha desc')
                ;
        
        return $db->fetchAll($select);
      
    }
    
    public function getConvocatoriaPorId($id, $tipoBD = NULL) 
    {
        if ($tipoBD) {
            Zend_Db_Table::setDefaultAdapter('dbconv');
            $db = $this->getDefaultAdapter();
            $this->_db = $db;
        }
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('ID = ?', $id);
        return $this->_db->fetchRow($query);
    }
    
    
    
    public function eliminarExperiencia($id){
        $where = $this->_db->quoteInto('idDetalleEmpresa=?', $id);
        $this->_db->delete($this->_name, $where);
    }
    
    public function validarEdicion()
    {
        $query = $this->_db
                ->select()->from(array('c' => $this->_name))
                ->joinInner(array('ce' => App_Model_ConvocatoriaEmpresa::TABLA_EMPRESA), 
                        'c.ID = ce.idConvocatoria')
                ->where('u.estado = ?', App_Model_Usuario::ESTADO_ACTIVO)
                ->where('u.tipoUsuario = ?', App_Model_Usuario::TIPO_ADMIN)
                ->limit(50);

        return $this->_db->fetchAll($query);
    }
    private function _updateDB($fecha) {
        Zend_Db_Table::setDefaultAdapter('dbconv');
        
        $db = $this->getDefaultAdapter();
        
        $select = $db->select()
                ->from(array('c' => $this->_name))
                ->where('CONCAT(c.limite," ",c.hora_lim) >= ?', $fecha)
                ->where('c.estado = ?', self::ESTADO_ACTIVO)
                ->where('c.tipo = ?', self::TIPO_CONVOCATORIA)                
                ->order('c.limite desc')
                ;
        $result = $db->fetchAll($select);
        
        
        foreach ($result as $item) {
            $this->actualizarDatos($item);
        }
        
        
        
    }
    public function reporteConvocatoria($tipo = NULL) {
        
        Zend_Db_Table::setDefaultAdapter('dbconv');
        
        $fecha = Zend_Date::now()->toString('Y-MM-dd HH:mm:ss');
        
        $db = $this->getDefaultAdapter();
        
        $select = $db->select()
                ->from(array('c' => $this->_name))                
                ->where('c.estado = ?', self::ESTADO_ACTIVO)
                ->where('c.tipo = ?', self::TIPO_CONVOCATORIA)
                ;
        if ($tipo == 1)
            $select->where('CONCAT(c.limite," ",c.hora_lim) >= ?', $fecha);
        if ($tipo == 2)
            $select->where('CONCAT(c.limite," ",c.hora_lim) <= ?', $fecha);
                
        $select->order('c.limite desc');
        
        $result = $db->fetchAll($select);
        
        return $result;
        
    }


   
}
