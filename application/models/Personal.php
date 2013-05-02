<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_Personal extends App_Db_Table_Abstract {

    protected $_name = 'personal';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_CONTACTO = 'personal';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idPersonal'])) {
            $id = (int) $datos['idPersonal'];
        }
        unset($datos['idPersonal']);
        
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->_db->update($this->_name, $datos, 'idPersonal = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->_db->insert($this->_name, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarPersonal($idEmpresa) 
    {
      $query = $this->_db->select()
          ->from(array('c' => $this->_name))
                ->where('c.estado = ?', App_Model_Personal::ESTADO_ACTIVO)
                        ->where('c.idEmpresa = ?', $idEmpresa)
                        ->order('c.apellido')                
                ;
      return $this->_db->fetchAll($query);
    }
    
    public function getPersonalPorId($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('idPersonal = ?', $id);
        return $this->_db->fetchRow($query);
    }
    
    
    
    public function eliminarPersonal($id){
        $where = $this->_db->quoteInto('idPersonal =?', $id);
        $this->_db->delete($this->_name, $where);
    }
    
   
}
