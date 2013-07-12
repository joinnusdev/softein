<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_DetaProfesion extends App_Db_Table_Abstract {

    protected $_name = 'detaprofesion';

    const TABLA_DETAPROFESION = 'detaprofesion';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    private function _guardar($datos, $condicion = NULL) {
       
        $id = 0;
        if (!empty($datos['idDetaProfesion'])) {
            $id = (int) $datos['idDetaProfesion'];
        }
        unset($datos['idDetaProfesion']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
              echo  $condicion = ' AND ' . $condicion;
              exit;
            }

           $cantidad = $this->_db->update(self::TABLA_DETAPROFESION, $datos, 'idDetaProfesion = ' . $id . $condicion);
         
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            
            $id = $this->_db->insert(self::TABLA_DETAPROFESION, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
    
    public function getDetaProfesion($idEvaluacion)
    {
        $query = $this->_db->select()
                ->from(array('d' => $this->_name), array('idProfesion'))
                ->where('d.idCriterioEvaluacion = ?', $idEvaluacion);
        
        return $this->_db->fetchCol($query);
    }
    
   
    
}