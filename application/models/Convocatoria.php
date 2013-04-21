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
   
    public function listarConvocatoria() 
    {
        $fecha = Zend_Date::now()->toString('Y-M-d');
        
        $db = $this->getAdapter();

        $select = $db->select()
                ->from(array('c' => $this->_name))
                ->joinLeft(array('ce' => App_Model_ConvocatoriaEmpresa::TABLA_EMPRESA), 
                        'c.ID = ce.idConvocatoria', 
                        array(
                            'est' =>'estado',
                            'empresa' => 'idEmpresa'
                            ))
                ->where('c.fecha >= ?', $fecha)
                ->where('c.estado = ?', self::ESTADO_ACTIVO)
                ->where('c.tipo = ?', self::TIPO_CONVOCATORIA)
                ->group('c.ID')
                ->order('c.fecha desc')
                ;
        
        return $db->fetchAll($select);
      
    }
    
    public function getConvocatoriaPorId($id) 
    {
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('ID = ?', $id);
        return $this->getAdapter()->fetchRow($query);
    }
    
    
    
    public function eliminarExperiencia($id){
        $where = $this->getAdapter()->quoteInto('idDetalleEmpresa=?', $id);
            $this->delete($where);
    }
    
    public function validarEdicion()
    {
        $query = $this->getAdapter()
                ->select()->from(array('c' => $this->_name))
                ->joinInner(array('ce' => App_Model_ConvocatoriaEmpresa::TABLA_EMPRESA), 
                        'c.ID = ce.idConvocatoria')
                ->where('u.estado = ?', App_Model_Usuario::ESTADO_ACTIVO)
                ->where('u.tipoUsuario = ?', App_Model_Usuario::TIPO_ADMIN)
                ->limit(50);

        return $this->getAdapter()->fetchAll($query);
    }
    
   
}
