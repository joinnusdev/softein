<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_Procesos extends App_Db_Table_Abstract {

    protected $_name = 'criterioseleccion';    
    protected $_evaluacion = 'criterioevaluacion';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_CRITERIO_SELECCION = 'criterioseleccion';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    private function _guardar($datos, $condicion = NULL) {
        
        $id = 0;
        if (!empty($datos['idCriterio'])) {
            $id = (int) $datos['idCriterio'];
        }
        unset($datos['idCriterio']);
        
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));
        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->_db->update($this->_name, $datos, 'idCriterio = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->_db->insert($this->_name, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarCriterios() 
    { 
        $query = $this->_db
                ->select()->from(array('criterio' => $this->_name))
                ->joinInner(array('convocatoria' => App_Model_Convocatoria::TABLA_CONVOCATORIA), 
                        'convocatoria.ID = criterio.idConvocatoria');
                
       return $this->_db->fetchAll($query);
    }
    
    public function getCriterioPorId($id) 
    {
        $query = $this->_db->select()
                ->from(array('criterio' => $this->_name))                
                ->where('criterio.idCriterio = ?', $id);
        return $this->_db->fetchRow($query);
    }
    
    
    
   public function eliminarCriterioSeleccion($idSeleccion){
        $where = $this->_db->quoteInto('idCriterio =?', $idSeleccion);
        $this->_db->delete($this->_name, $where);
        
        $where = $this->_db->quoteInto('idCriterio =?', $idSeleccion);
        $this->_db->delete($this->_evaluacion, $where);
        
    }
    
    
    
    public function getCriterioSeleccionConvocatoria($idConvocatoria){
        $query = $this->_db->select()
                ->from(array('seleccion' => $this->_name))                
                ->where('seleccion.idConvocatoria = ?', $idConvocatoria);
        return $this->_db->fetchRow($query);
        
    }
   
}
