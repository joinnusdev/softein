<?php

class App_Form_CrearPersonal extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idPersonal');        
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('nombre');    
        $e->setAttrib('required', 'required');
        $e->setAttrib('size', '50');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('apellido');
        $e->setAttrib('required', 'required');
        $e->setAttrib('size', '50');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('cargo');    
        $e->setAttrib('required', 'required');
        $e->setAttrib('size', '50');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('email');        
        $e->setFilters(array("StripTags", "StringTrim"));        
        $v = new Zend_Validate_EmailAddress();
        $e->setAttrib('class', 'span8');
        $e->addValidator($v);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('telefono');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('numerodocumento');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Select('nivelacademico');
        $e->addMultiOption('Doctorado', 'Doctorado')
            ->addMultiOption('Maestria', 'Maestria')
            ->addMultiOption('Titulado', 'Titulado')
            ->addMultiOption('Bachiller', 'Bachiller')
            ;
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('telefono');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Radio('tipo');
        $e->addMultiOptions(array(
            '1' => 'oferente',
            '2' => 'contratado')
        );
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('expanos');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $e->setAttrib('class', 'span3');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('expmeses');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $e->setAttrib('class', 'span3');
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
}