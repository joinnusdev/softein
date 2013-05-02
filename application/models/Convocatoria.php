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
        $fecha = Zend_Date::now()->toString('Y-M-d');
        
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
        $select->where('c.limite >= ?', $fecha)
                ->where('c.estado = ?', self::ESTADO_ACTIVO)
                ->where('c.tipo = ?', self::TIPO_CONVOCATORIA)
                ->group('c.ID')
                ->order('c.fecha desc')
                ;
        //echo $select;
        return $db->fetchAll($select);
      
    }
    
    public function getConvocatoriaPorId($id) 
    {
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
        
        $db = $this->_db;
        
        $select = $db->select()
                ->from(array('c' => $this->_name))
                ->where('c.limite >= ?', $fecha)
                ->where('c.estado = ?', self::ESTADO_ACTIVO)
                ->where('c.tipo = ?', self::TIPO_CONVOCATORIA)
                ->group('c.ID')
                ->order('c.limite desc')
                ;
        
        $result = $db->fetchAll($select);
        
        Zend_Db_Table::setDefaultAdapter('db');
        foreach ($result as $item) {
            $this->actualizarDatos($item);
        }
        
        
        
    }


   
}
