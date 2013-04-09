<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_Contacto extends App_Db_Table_Abstract {

    protected $_name = 'contacto';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_CONTACTO = 'contacto';
    
    
    
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

            $cantidad = $this->update($datos, 'idContacto = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarContacto() 
    {
      $query = $this->getAdapter()
                ->select()->from(array('c' => $this->_name))
                //->where('c.estado = ?', App_Model_Contacto::ESTADO_ACTIVO)
                ->limit(50);
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
