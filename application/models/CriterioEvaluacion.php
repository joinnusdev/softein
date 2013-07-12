<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_CriterioEvaluacion extends App_Db_Table_Abstract {

    protected $_name = 'criterioevaluacion';    

    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_CRITERIOS_EVALUACION = 'criterioevaluacion';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    
    private function _guardar($datos, $condicion = NULL) {
        
        $id = 0;
        if (!empty($datos['idCriterioEvaluacion'])) {
            $id = (int) $datos['idCriterioEvaluacion'];
        }
        unset($datos['idCriterioEvaluacion']);
        
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));
        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->_db->update($this->_name, $datos, 'idCriterioEvaluacion = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            
            $id = $this->_db->insert($this->_name, $datos);
            
        }
        return $this->getDefaultAdapter()->lastInsertId();
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarCriteriosEvaluacion($criterioEvaluacion) 
    { 
        $query = $this->_db
                ->select()->from(array('evaluacion' => $this->_name),
                        array(
                            'evaluacion.idCriterioEvaluacion',
                            'evaluacion.cargo',
                            'evaluacion.nivelAcademico',
                            'seleccion.idCriterio',
                            //'profesion.descripcion as profesion',
                            //'especialidad.descripcion as especialidad',
                            'subEspecialidad.descripcion as subEspecialidad'
                        ))
                ->joinInner(array('seleccion' => App_Model_Procesos::TABLA_CRITERIO_SELECCION), 
                        'seleccion.idCriterio = evaluacion.idCriterio')

                /*->joinInner(array('profesion' => App_Model_Profesion::TABLA_PROFESION), 
                        'profesion.idProfesion = evaluacion.idProfesion')
                ->joinInner(array('especialidad' => App_Model_Especialidad::TABLA_ESPECIALIDAD), 
                        'especialidad.idEspecialidad = evaluacion.idEspecialidad')*/
               ->joinInner(array('subEspecialidad' => App_Model_SubEspecialidad::TABLA_SUBESPECIALIDAD), 
                        'evaluacion.idSubEspecialidad = subEspecialidad.idSubEspecialidad')
/*
                ->joinLeft(array('profesion' => App_Model_Profesion::TABLA_PROFESION), 
                        'profesion.idProfesion = evaluacion.idProfesion')
                ->joinLeft(array('especialidad' => App_Model_Especialidad::TABLA_ESPECIALIDAD), 
                        'especialidad.idEspecialidad = evaluacion.idEspecialidad')
               ->joinLeft(array('subEspecialidad' => App_Model_SubEspecialidad::TABLA_SUBESPECIALIDAD), 
                        'subEspecialidad.idSubEspecialidad = evaluacion.idSubEspecialidad')
*/
               ->where('seleccion.idCriterio = ?', $criterioEvaluacion);
                
       return $this->_db->fetchAll($query);
    }
    
     public function listarCargosCriteriosEvaluacion() 
    { 
        $query = $this->_db
                ->select()->from(array('evaluacion' => $this->_name),
                        array(
                            'evaluacion.idCriterioEvaluacion',
                            'evaluacion.cargo',
                            'evaluacion.nivelAcademico'
                            
                        ));
                
       return $this->_db->fetchAll($query);
    }
    
    
    
    
    public function getCriterioEvaluacionPorId($idEvaluacion) 
    {
        $query = $this->_db->select()
                ->from(array('evaluacion' => $this->_name))                
                ->where('evaluacion.idCriterioEvaluacion = ?', $idEvaluacion);
        return $this->_db->fetchRow($query);
    }
    
    
    
    public function eliminarCriterioEvaluacion($idEvaluacion){
        $where = $this->_db->quoteInto('idCriterioEvaluacion =?', $idEvaluacion);
        $this->_db->delete($this->_name, $where);
    }
    
   
}
