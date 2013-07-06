<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_DetaPersonal extends App_Db_Table_Abstract {

    protected $_name = 'detapersonal';

    const TABLA_EMPRESA = 'detapersonal';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    private function _guardar($datos, $condicion = NULL) {
       
        $id = 0;
        if (!empty($datos['idDetallePersonal'])) {
            $id = (int) $datos['idDetallePersonal'];
        }
        unset($datos['idDetallePersonal']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
              echo  $condicion = ' AND ' . $condicion;
              exit;
            }

           $cantidad = $this->_db->update(self::TABLA_EMPRESA, $datos, 'idDetallePersonal = ' . $id . $condicion);
         
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            
            $id = $this->_db->insert(self::TABLA_EMPRESA, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarPersonal($id)
    {
        $query = $this->_db
                ->select()->from(array('e' => $this->_name))
                ->joinInner(array('p' => App_Model_Personal::TABLA_CONTACTO), 
                        'e.idPersonal = p.idPersonal')
                ->joinInner(array('c' => App_Model_CriterioEvaluacion::TABLA_CRITERIOS_EVALUACION), 
                        'c.idCriterioEvaluacion = e.idCriterioEvaluacion', 
                        array('idc' => 'idCriterioEvaluacion', 'cargop' => 'cargo'))
                ->where('e.idConvocatoriaExperiencia = ?', $id);

        return $this->_db->fetchAll($query);
    }
    
    public function getEmpresaPorId($id, $tipo = NULL) 
    {
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('idEmpresa = ?', $id);
        if ($tipo)
            $query->where ('idTipoUsuario = ?', $tipo);
        
        return $this->_db->fetchRow($query);
    }    
    
    public function getConvocatoriaPersonal($idConvocatoriaExp) 
    {
        $query = $this->_db->select()
                ->from(array('de' => $this->_name))
                ->joinInner(array('p' => App_Model_Personal::TABLA_CONTACTO), 
                        'de.idPersonal= p.idPersonal')                
                ->where('de.idConvocatoriaExperiencia = ?', $idConvocatoriaExp)
                ;
        return $this->_db->fetchAll($query);
    }   
    
    public function getValidarEmpresaLogin($dato,$tipo) 
    {
         $query = $this->_db->select()
                ->from($this->_name);
              
            if ($tipo == 1){ //email
                $query->where ('email = ?', $dato);
                 
            }
            if ($tipo == 2){ //estado usuario
                $query->where ('idEmpresa = ?', $dato);
            }
            
     
        return $this->_db->fetchRow($query);
    }
    
    public function eliminarDetalle($id){
        $where = $this->_db->quoteInto('idConvocatoriaExperiencia =?', $id);
        $this->_db->delete(self::TABLA_EMPRESA, $where);
    }
}