<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_DetaExperiencia extends App_Db_Table_Abstract {

    protected $_name = 'detaexperiencia';

    const TABLA_EMPRESA = 'detaexperiencia';
    
    public function init(){
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
    
    private function _guardar($datos, $condicion = NULL) {
       
        $id = 0;
        if (!empty($datos['idDetalleExperiencia'])) {
            $id = (int) $datos['idDetalleExperiencia'];
        }
        unset($datos['idDetalleExperiencia']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
              echo  $condicion = ' AND ' . $condicion;
              exit;
            }

           $cantidad = $this->_db->update(self::TABLA_EMPRESA, 
               $datos, 'idDetalleExperiencia = ' . $id . $condicion
           );
         
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            
            $id = $this->_db->insert(self::TABLA_EMPRESA, $datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarUsuario()
    {
        $query = $this->_db
                ->select()->from(array('e' => $this->_name))
                ->where('u.estado = ?', App_Model_Usuario::ESTADO_ACTIVO)
                ->where('u.tipoUsuario = ?', App_Model_Usuario::TIPO_ADMIN)
                ->limit(50);

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
        $this->_db->delete(self::TABLA_EMPRESA,$where);
    }
    
    public function getExperienciaEmpresa($idEmpresa, $idConvocatoria) 
    {
        $query = $this->_db->select()
                ->from(array('ce' => App_Model_ConvocatoriaEmpresa::TABLA_EMPRESA))
                ->joinInner(array('d' => $this->_name), 
                        'ce.idConvocatoriaExperiencia = d.idConvocatoriaExperiencia')
                ->joinInner(array('e' => App_Model_Experiencia::TABLA_DETALLEEMPRESA), 
                        'd.idExperiencia = e.idDetalleEmpresa')
                ->joinInner(array('p' => App_Model_Pais::TABLA_EMPRESA), 
                        'e.servicioPais = p.idPais')
                ->where('ce.idEmpresa = ?', $idEmpresa)
                ->where('ce.idConvocatoria = ?', $idConvocatoria)
                ;
        return $this->_db->fetchAll($query);
    }   
}