<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_DetaPersonal extends App_Db_Table_Abstract {

    protected $_name = 'detapersonal';

    const TABLA_EMPRESA = 'detapersonal';
    
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

           $cantidad = $this->update($datos, 'idDetallePersonal = ' . $id . $condicion);
         
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarPersonal($id)
    {
        $query = $this->getAdapter()
                ->select()->from(array('e' => $this->_name))
                ->joinInner(array('p' => App_Model_Personal::TABLA_CONTACTO), 
                        'e.idPersonal = p.idPersonal')
                ->where('e.idConvocatoriaExperiencia = ?', $id);

        return $this->getAdapter()->fetchAll($query);
    }
    
    public function getEmpresaPorId($id, $tipo = NULL) 
    {
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('idEmpresa = ?', $id);
        if ($tipo)
            $query->where ('idTipoUsuario = ?', $tipo);
        
        return $this->getAdapter()->fetchRow($query);
    }    
    
    public function getValidarEmpresaLogin($dato,$tipo) 
    {
         $query = $this->getAdapter()->select()
                ->from($this->_name);
              
            if ($tipo == 1){ //email
                $query->where ('email = ?', $dato);
                 
            }
            if ($tipo == 2){ //estado usuario
                $query->where ('idEmpresa = ?', $dato);
            }
            
     
        return $this->getAdapter()->fetchRow($query);
    }
    
    public function eliminarDetalle($id){
        $where = $this->getAdapter()->quoteInto('idConvocatoriaExperiencia =?', $id);
        $this->delete($where);
    }
}