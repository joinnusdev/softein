<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_Experiencia extends App_Db_Table_Abstract {

    protected $_name = 'detalleempresa';    
    protected $_namePais = 'pais';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_DETALLEEMPRESA = 'detalleempresa';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
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

            $cantidad = $this->_db->update(self::TABLA_DETALLEEMPRESA, $datos, 'idDetalleEmpresa = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->_db->insert(self::TABLA_DETALLEEMPRESA, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarExperiencia($idEmpresa = NULL) 
    {
       $db = $this->_db;

       $select = $db->select()
                
                ->from(array('e'=>$this->_name),array(
                    'e.idDetalleEmpresa',
                    'e.descripcion',
                    'e.servicioNombre',
                    'e.servicioRuc',
                    'e.fechaInicio',
                    'e.fechaFin',
                    'p.idPais',
                    'p.pais'
                    
                    ))
             
                ->join(array('p'=>$this->_namePais), 'e.servicioPais= p.idPais','');
                
       if ($idEmpresa)
           $select->where('e.idEmpresa = ?', $idEmpresa);

        return $db->fetchAll($select);
      
      
      
      
      
      
      
    }
    
    public function getExperienciaPorId($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('idDetalleEmpresa = ?', $id);
        return $this->_db->fetchRow($query);
    }
    
    
    
    public function eliminarExperiencia($id){
        $where = $this->_db->quoteInto('idDetalleEmpresa=?', $id);
            $this->_db->delete(self::TABLA_DETALLEEMPRESA, $where);
    }
    
   
}
