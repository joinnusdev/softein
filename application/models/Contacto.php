<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_Contacto extends App_Db_Table_Abstract {

    protected $_name = 'contacto';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_CONTACTO = 'contacto';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idContacto'])) {
            $id = (int) $datos['idContacto'];
        }
        unset($datos['idContacto']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->_db->update($this->_name, $datos, 'idContacto = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->_db->insert($this->_name, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarContacto($idEmpresa) 
    {
      $query = $this->_db
                ->select()->from(array('c' => $this->_name))
                ->where('c.idEmpresa = ?', $idEmpresa)
                ->limit(50);
      return $this->_db->fetchAll($query);
    }
    
    public function getContactoPorId($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('idContacto = ?', $id);
        return $this->_db->fetchRow($query);
    }
    
    
    
    public function eliminarContacto($id){
        $where = $this->_db->quoteInto('idContacto =?', $id);
            $this->_db->delete($this->_name, $where);
    }
    
   
}
