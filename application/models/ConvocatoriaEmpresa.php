<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_ConvocatoriaEmpresa extends App_Db_Table_Abstract {

    protected $_name = 'cempresa';
    
    const ESTADO_ACTIVO = '1';
    const ESTADO_ELIMINADO = '0';
    const TABLA_EMPRESA = 'cempresa';    
    
    private function _guardar($datos, $condicion = NULL) {
       
        $id = 0;
        if (!empty($datos['idConvocatoriaExperiencia'])) {
            $id = (int) $datos['idConvocatoriaExperiencia'];
        }
        unset($datos['idConvocatoriaExperiencia']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
              echo  $condicion = ' AND ' . $condicion;
              exit;
            }

           $cantidad = $this->update($datos, 'idConvocatoriaExperiencia= ' . $id . $condicion);
         
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
    
    public function getConvocatoriaEmpresa($idConvocatoria, $idEmpresa = NULL) 
    {
        $query = $this->getAdapter()->select()
                ->from(array('ce' => $this->_name))
                ->joinInner(array('c' => App_Model_Convocatoria::TABLA_CONVOCATORIA), 
                        'ce.idConvocatoria = c.ID', 
                        array('ID', 'proceso', 'fecha', 
                            'limite', 'codigoproceso' => 'codigo'
                            )
                        )
                ->joinInner(array('e' => App_Model_Empresa::TABLA_EMPRESA), 
                        'ce.idEmpresa = e.idEmpresa', 
                        array('idEmpresa', 'nombreEmpresa', 'telefono', 
                            'paisEmpresa', 'numeroDocumento', 'email')
                        )
                
                
                ->where('ce.idConvocatoria = ?', $idConvocatoria)
                ;
        if ($idEmpresa){
            $query->where('ce.idEmpresa = ?', $idEmpresa);
            return $this->getAdapter()->fetchRow($query);
        }
        return $this->getAdapter()->fetchAll($query);
        
    }    
    
    public function getExperienciaDeta($idConvocatoria) 
    {
        $query = $this->getAdapter()->select()
                ->from(array('ce' => $this->_name))
                ->joinInner(array('de' => App_Model_DetaExperiencia::TABLA_EMPRESA), 
                        'ce.idConvocatoriaExperiencia = de.idConvocatoriaExperiencia')                
                ->where('ce.idConvocatoria = ?', $idConvocatoria)
                ;
        return $this->getAdapter()->fetchAll($query);
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