<?php

/**
 * Description of User
 *
 * @author James 
 */
class App_Model_Especialidad extends App_Db_Table_Abstract {

    protected $_name = 'especialidad';
    const TABLA_ESPECIALIDAD = 'especialidad';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
   
    
    public function getEspecialidadPorProfesion($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name, array('idEspecialidad', 'descripcion'))
                ->where('idProfesion IN (?)', $id);
        
        return $this->_db->fetchAll($query);
    }
    
    public function getComboEspecialidad($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name, array('idEspecialidad', 'descripcion'))
                ->where('idProfesion = ?', $id);
        
        return $this->_db->fetchPairs($query);
    }
    
    public function getEspecialidadArray($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name, array('idEspecialidad', 'descripcion'))
                ->where('idProfesion IN (?)', $id);        
        return $this->_db->fetchPairs($query);
    }
    
   
}
