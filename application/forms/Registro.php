<?php

class App_Form_Registro extends App_Form
{
    public function init() {
        
        parent::init();
        
        /*========================= DATOS DEL REGISTRO ==========================*/
        
         $e = new Zend_Form_Element_Text('idEmpresa');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        /*
        $e = new Zend_Form_Element_Text('paisEmpresa');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setAttrib('class', 'required');
        $e->setRequired(true);
        $this->addElement($e);
        */
        
        $modelPais = new App_Model_Pais();
        $listaPais = $this->fetchPairs($modelPais->listarPais());
        
        $this->addElement(new Zend_Form_Element_Select('paisEmpresa'));
        $this->getElement('paisEmpresa')->addMultiOption('', 'Seleccione Pais');
        $this->getElement('paisEmpresa')->addMultiOptions($listaPais);
        $this->getElement('paisEmpresa')->setAttrib('class', 'required');
        $this->getElement('paisEmpresa')->setRequired();         

        
        
        
        
        $this->addElement(new Zend_Form_Element_Select('tipoDocumento'));
        $this->getElement('tipoDocumento')->addMultiOption('', 'Seleccione Documento');
        $this->getElement('tipoDocumento')->addMultiOption('2', 'Ruc');
        $this->getElement('tipoDocumento')->addMultiOption('4', 'Carnet Internacional');
        
        $this->getElement('tipoDocumento')->setAttrib('class', 'required');
        $this->getElement('tipoDocumento')->setRequired();
        $this->getElement('tipoDocumento')->removeDecorator('htmlTag');
        $this->getElement('tipoDocumento')->removeDecorator('Errors');
        
        
        $e = new Zend_Form_Element_Text('numeroDocumento');
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '12');
        $e->setAttrib('maxlength', '12');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired();
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('nombreEmpresa');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setAttrib('class', 'required');
        $e->setAttrib('size', '40');
        
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('representanteLegal');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setAttrib('class', 'required');
        $e->setAttrib('size', '40');
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('email');
        $e->setAttrib('class', 'required email');
        $e->setFilters(array("StripTags", "StringTrim"));
        $v = new Zend_Validate_EmailAddress();
        $e->addValidator($v);
        $e->setRequired(true);
        $e->addFilter(new Zend_Filter_HtmlEntities());
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('telefono');
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '9');
        $e->setAttrib('maxlength', '9');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Password('clave');
        $e->setAttrib('class', 'required');
        $e->setAttrib('minlength', '8');
        
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>5,'max'=>30));
        $e->addValidator($v);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Guardar')->setAttrib('class', 'submit');
        $this->addElement($e);
        
      
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
            $data[$index[$arrayKey[0]]] = $index[$arrayKey[4]];
            else
            $data[$index[$arrayKey[0]]] = $index[$arrayKey[0]];    
        }
        return $data;
    }
}
