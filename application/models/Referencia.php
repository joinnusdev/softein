<?php

/**
 * Description of User
 *
 * @author James O.
 */
class App_Model_Referencia extends App_Db_Table_Abstract {

    protected $_name = 'referencia';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_REFERENCIA = 'referencia';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idReferencia'])) {
            $id = (int) $datos['idReferencia'];
        }
        unset($datos['idReferencia']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->_db->update($this->_name, $datos, 'idReferencia = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->_db->insert($this->_name, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarReferencia($idEmpresa)
    {
      $query = $this->_db
                ->select()->from(array('c' => $this->_name))
                ->where('c.idEmpresa = ?', $idEmpresa);
      return $this->_db->fetchAll($query);
    }
    
    public function getReferenciaPorId($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('idReferencia = ?', $id);
        return $this->_db->fetchRow($query);
    }
    
    public function eliminarContacto($id){
        $where = $this->_db->quoteInto('idReferencia =?', $id);
        $this->_db->delete($this->_name, $where);
    }
    
   
}
