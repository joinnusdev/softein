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
    public function init(){
        
        Zend_Db_Table::setDefaultAdapter('db');
        $this->_db = $this->getDefaultAdapter();
    }
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
            }

           $cantidad = $this->_db->update('cempresa', $datos, 'idConvocatoriaExperiencia= ' . $id . $condicion);
         
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->_db->insert('cempresa' ,$datos);
            return $this->_db->lastInsertId();
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
    
    public function getConvocatoriaEmpresa($idConvocatoria, $idEmpresa = NULL) 
    {
      $query = $this->_db->select()
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
                            'paisEmpresa', 'numeroDocumento', 'email',
                            'tipoOrganizacion','aniosExperiencia')
                        )
                ->joinLeft(array('p' => App_Model_Pais::TABLA_EMPRESA), 
                        'e.paisEmpresa = p.idPais', 
                        array('pais')
                        )
                ->where('ce.idConvocatoria = ?', $idConvocatoria)
                ;
        if ($idEmpresa){
            $query->where('ce.idEmpresa = ?', $idEmpresa);            
            return $this->_db->fetchRow($query);
        }
        
        return $this->_db->fetchAll($query);
        
    }    
    
    public function getExperienciaDeta($idConvocatoria) 
    {
        $query = $this->_db->select()
                ->from(array('ce' => $this->_name))
                ->joinInner(array('de' => App_Model_DetaExperiencia::TABLA_EMPRESA), 
                        'ce.idConvocatoriaExperiencia = de.idConvocatoriaExperiencia')                
                ->where('ce.idConvocatoria = ?', $idConvocatoria)
                ;
        return $this->_db->fetchAll($query);
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
}