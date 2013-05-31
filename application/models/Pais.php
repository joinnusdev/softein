<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_Pais extends App_Db_Table_Abstract {

    protected $_name = 'pais';    

    const TABLA_EMPRESA = 'pais';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    public function listarPais() 
    {
        $query = $this->_db
                ->select()->from(array('e' => $this->_name))
                ->order('pais');
                
        return $this->_db->fetchAll($query);
    }
    
    public function listarPair() 
    {
        $query = $this->_db
                ->select()->from(array('e' => $this->_name), array('idPais', 'pais'))
                ->order('pais');
                
        return $this->_db->fetchPairs($query);
    }
}

