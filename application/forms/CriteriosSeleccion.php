<?php

class App_Form_CriteriosSeleccion extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idPersonal');        
        $this->addElement($e);
            
        $modelConvocatoria = new App_Model_Convocatoria();
        $listaConvocatoria = $this->fetchPairs($modelConvocatoria->reporteConvocatoria(1));
        
        $this->addElement(new Zend_Form_Element_Select('idConvocatoria'));
        $this->getElement('idConvocatoria')->addMultiOption('', '-- Seleccione Convocatoria --');
        $this->getElement('idConvocatoria')->addMultiOptions($listaConvocatoria);
        $this->getElement('idConvocatoria')->setAttrib('class', 'required');
        
        $e = new Zend_Form_Element_Text('antiguedadEmpresa');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '3');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('puntajeAntiguedad');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('montoMinimo');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('anosMontoMinimo');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $e->setAttrib('size', '1');
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('puntajeMonto');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        



        
        $e = new Zend_Form_Element_Text('experienciaEspecificaAnos');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '3');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('experienciaEspecificaMeses');        
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('puntajeExperienciaEspecifica');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('experienciaGeneralAnos');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '3');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('experienciaGeneralMeses');        
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('puntajeExperienciaGeneral');        
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $e->setAttrib('size', '5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Textarea('resumenExperiencia');        
         $e->setAttrib('cols', '50');
         $e->setAttrib('rows', '3');
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Guardar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);
        
        $this->addElement('hash', 'csrf', array(
                    'ignore' => true,
                ));
        
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
            $data[$index[$arrayKey[0]]] = $index[$arrayKey[3]];
            else
            $data[$index[$arrayKey[0]]] = $index[$arrayKey[0]];    
        }
        return $data;
      }
}