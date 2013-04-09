<?php

class App_Form_Registro extends App_Form
{
    public function init() {
        
        parent::init();
        
        /*========================= DATOS DEL REGISTRO ==========================*/
        
         $e = new Zend_Form_Element_Text('idEmpresa');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('paisEmpresa');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setAttrib('class', 'required');
        $e->setRequired(true);
        $this->addElement($e);
        
        $this->addElement(new Zend_Form_Element_Select('tipoDocumento'));
        $this->getElement('tipoDocumento')->addMultiOption('', 'Seleccione Documento');
        $this->getElement('tipoDocumento')->addMultiOption('1', 'Pasaporte');
        $this->getElement('tipoDocumento')->addMultiOption('2', 'Ruc');
        $this->getElement('tipoDocumento')->addMultiOption('3', 'DNI');
        $this->getElement('tipoDocumento')->setAttrib('class', 'required');
        $this->getElement('tipoDocumento')->setRequired();
        $this->getElement('tipoDocumento')->removeDecorator('htmlTag');
        $this->getElement('tipoDocumento')->removeDecorator('Errors');
        
        
        $e = new Zend_Form_Element_Text('nroDocumento');
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
        $e->setLabel('Password');
        $e->setAttrib('class', 'required');
        $e->setAttrib('minlength', '6');
        
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
}
