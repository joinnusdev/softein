<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_Pais extends App_Db_Table_Abstract {

    protected $_name = 'pais';    

    const TABLA_EMPRESA = 'pais';
    
    public function listarPais() 
    {
        $query = $this->getAdapter()
                ->select()->from(array('e' => $this->_name))
                ->order('pais');
                
        return $this->getAdapter()->fetchAll($query);
    }
}

