<?php

class App_Form_FiltrarReporte extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('fechaInicial');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Text('fechaFinal');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Submit('buscar');
        $e->setLabel('Buscar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);
        
        //usuario
        $modelUsuario = new App_Model_User();
        $listaUsuarioEstilista = $this->fetchPairs($modelUsuario->listarDatos());
        
        $this->addElement(new Zend_Form_Element_Select('idUsuario'));
        $this->getElement('idUsuario')->addMultiOption('', 'Seleccione Estilista');
        $this->getElement('idUsuario')->addMultiOptions($listaUsuarioEstilista);
        $this->getElement('idUsuario')->setAttrib('class', 'span8');
        $this->getElement('idUsuario')->setRequired();  
        foreach($this->getElements() as $e) {
            $e->clearDecorators();
            $e->addDecorator("ViewHelper");
         }
        
        
        
    }
           function fetchPairs($array){
        $data=array();
        foreach ($array as $index){
            $arrayKey=array_keys($index);
            if(count($arrayKey)>=2)
            $data[$index[$arrayKey[0]]] = $index[$arrayKey[1]];
            else
            $data[$index[$arrayKey[0]]] = $index[$arrayKey[0]];    
        }
        return $data;
    }
}