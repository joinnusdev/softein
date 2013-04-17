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
   
    public function listarUsuario()
    {
        $query = $this->getAdapter()
                ->select()->from(array('e' => $this->_name))
                ->where('u.estado = ?', App_Model_Usuario::ESTADO_ACTIVO)
                ->where('u.tipoUsuario = ?', App_Model_Usuario::TIPO_ADMIN)
                ->limit(50);

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
}