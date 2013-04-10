<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_Experiencia extends App_Db_Table_Abstract {

    protected $_name = 'detalleempresa';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_DETALLEEMPRESA = 'detalleempresa';
    
    
    
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idDetalleEmpresa'])) {
            $id = (int) $datos['idDetalleEmpresa'];
        }
        unset($datos['idDetalleEmpresa']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'idDetalleEmpresa = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarExperiencia() 
    {
      $query = $this->getAdapter()
                ->select()->from(array('e' => $this->_name));
                //->where('c.estado = ?', App_Model_Contacto::ESTADO_ACTIVO)
                
      return $this->getAdapter()->fetchAll($query);
    }
    
    public function getExperienciaPorId($id) 
    {
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('idDetalleEmpresa = ?', $id);
        return $this->getAdapter()->fetchRow($query);
    }
    
    
    
    public function eliminarExperiencia($id){
        $where = $this->getAdapter()->quoteInto('idDetalleEmpresa=?', $id);
            $this->delete($where);
    }
    
   
}