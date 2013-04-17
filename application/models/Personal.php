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

            $cantidad = $this->update($datos, 'idPersonal = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarPersonal() 
    {
      $query = $this->getAdapter()
                ->select()->from(array('c' => $this->_name))
                ->where('c.estado = ?', App_Model_Personal::ESTADO_ACTIVO)->order('c.apellido')
                ;
      return $this->getAdapter()->fetchAll($query);
    }
    
    public function getContactoPorId($id) 
    {
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('idContacto = ?', $id);
        return $this->getAdapter()->fetchRow($query);
    }
    
    
    
    public function eliminarContacto($id){
        $where = $this->getAdapter()->quoteInto('idContacto =?', $id);
            $this->delete($where);
    }
    
   
}
