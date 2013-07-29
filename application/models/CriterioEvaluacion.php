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

            $where = $this->_db->quoteInto('idCriterioEvaluacion =?', $id);
            $this->_db->delete(App_Model_DetaProfesion::TABLA_DETAPROFESION, $where);            
            $this->_db->delete(App_Model_DetaEspecialidad::TABLA_DETAESPECIALIDAD, $where);
            
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
               ->joinLeft(array('subEspecialidad' => App_Model_SubEspecialidad::TABLA_SUBESPECIALIDAD), 
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
    
     public function listarCargosCriteriosEvaluacion($idConvocatoria) 
    { 
       $query = $this->_db
                ->select()->from(array('evaluacion' => $this->_name),
                        array(
                            'evaluacion.idCriterioEvaluacion',
                            'evaluacion.cargo',
                            'evaluacion.nivelAcademico'
                            
                        ))
               ->joinInner(array('seleccion' => App_Model_Procesos::TABLA_CRITERIO_SELECCION), 
                        'seleccion.idCriterio = evaluacion.idCriterio')
               ->where('seleccion.idConvocatoria = ?', $idConvocatoria);
        
                
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
    
    public function listarCargos($idConvocatoria){
        $query = "SELECT ce.idCriterioEvaluacion, ce.cargo, 
                    ce.experienciaGeneralAnos,ce.experienciaGeneralMeses
                    from criterioevaluacion as ce
                    inner join criterioseleccion as cs on ce.idCriterio = cs.idCriterio
                    where cs.idConvocatoria = ".$idConvocatoria;
        return $this->_db->fetchAll($query);
    }
    
    public function mostrarProfesionxCargo($idConvocatoria){
        $query = "select ce.idCriterioEvaluacion,cs.idConvocatoria,p.descripcion as profesion from detaprofesion as dp
                inner join criterioevaluacion as ce on ce.idCriterioEvaluacion = dp.idCriterioEvaluacion
                inner join criterioseleccion as cs on cs.idCriterio= ce.idCriterio
                inner join profesion as p on   p.idProfesion = dp.idProfesion
                where cs.idConvocatoria = ".$idConvocatoria;
        return $this->_db->fetchAll($query);
    }
    
    public function mostrarEspecialidadxCargo($idConvocatoria){
        $query = "select ce.idCriterioEvaluacion,cs.idConvocatoria,e.descripcion as especialidad 
                from detaespecialidad as de
                inner join criterioevaluacion as ce on ce.idCriterioEvaluacion = de.idCriterioEvaluacion
                inner join criterioseleccion as cs on cs.idCriterio= ce.idCriterio
                inner join especialidad as e on e.idEspecialidad = de.idEspecialidad
                where cs.idConvocatoria =  ".$idConvocatoria;
        return $this->_db->fetchAll($query);
    }
    
    public function mostrarSubEspecialidadxCargo($idConvocatoria){
        $query = "select  se.idSubEspecialidad, se.descripcion as subEspecialidad  from criterioevaluacion as ce
                inner join criterioseleccion as cs on cs.idCriterio= ce.idCriterio
                inner join subespecialidad  as se on se.idSubEspecialidad = ce.idSubEspecialidad
                where cs.idConvocatoria =  ".$idConvocatoria;
        return $this->_db->fetchAll($query);
        
    }
    
    
    public function datosCargoPresentado($idConvocatoria,$cargo,$idEmpresa){
        $query = "select p.idPersonal,p.cargo as cargoPresentado,p.expanos,p.expmeses,
	e.nombreEmpresa,e.idEmpresa,
	ce.cargo as cargoPostular,
	profesion.descripcion as profesion,
	especialidad.descripcion as especialidad,
	subespecialidad.descripcion as subespecialidad
	from personal as p 
	inner join empresa as e on e.idEmpresa = p.idEmpresa
	inner join detapersonal as dp on dp.idPersonal = p.idPersonal
	inner join profesion as profesion on profesion.idProfesion = p.idProfesion
	left join especialidad as especialidad on especialidad.idEspecialidad = p.idEspecialidad
	left join subespecialidad as subespecialidad on subespecialidad.idSubEspecialidad = p.idSubEspecialidad
	inner join criterioevaluacion as ce on ce.idCriterioEvaluacion = dp.idCriterioEvaluacion
	inner join criterioseleccion as cs on cs.idCriterio = ce.idCriterio
	where cs.idConvocatoria = ". $idConvocatoria ."
	and ce.cargo = '". $cargo ."'
	and e.idEmpresa = ".$idEmpresa;
	return $this->_db->fetchRow($query);      
    }
}
