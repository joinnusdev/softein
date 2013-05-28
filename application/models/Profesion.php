<?php

/**
 * Description of User
 *
 * @author James 
 */
class App_Model_Profesion extends App_Db_Table_Abstract {

    protected $_name = 'profesion';    
    const TABLA_PROFESION = 'profesion';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
   
    public function listarProfesiones() 
    {
      $query = $this->_db
          ->select()->from($this->_name)
          ->order('descripcion')
          ;
      return $this->_db->fetchPairs($query);
    }
    
    public function getContactoPorId($id) 
    {
        $query = $this->_db->select()
                ->from($this->_name)
                ->where('idContacto = ?', $id);
        return $this->_db->fetchRow($query);
    }
    
   
}
