<?php

/**
 * Description of User
 *
 * @author James 
 */
class App_Model_SubEspecialidad extends App_Db_Table_Abstract {

    protected $_name = 'subespecialidad';
    const TABLA_SUBESPECIALIDAD = 'subespecialidad';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
   
    
    public function getSubEspecialidad($id)
    {
        $query = $this->_db->select()
                ->from($this->_name, array('idSubEspecialidad', 'descripcion'))
                ->where('idEspecialidad IN (?)', $id);
        
        return $this->_db->fetchAll($query);
    }
    public function getComboSubEspecialidad($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name, array('idSubEspecialidad', 'descripcion'))
                ->where('idEspecialidad = ?', $id);
        
        return $this->_db->fetchPairs($query);
    }
    
   
}
