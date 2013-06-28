<?php

class App_Form_CriteriosSeleccion extends App_Form
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
        $e->setAttrib('class', 'email');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $v = new Zend_Validate_EmailAddress();
        $e->setAttrib('size', '20');
        $e->addValidator($v);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('telefono');
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '9');
        $e->setAttrib('maxlength', '9');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('numerodocumento');
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '8');
        $e->setAttrib('maxlength', '8');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Select('nivelacademico');
        $e->addMultiOption('Doctorado', 'Doctorado')
            ->addMultiOption('Maestria', 'Maestria')
            ->addMultiOption('Titulado', 'Titulado')
            ->addMultiOption('Bachiller', 'Bachiller');
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        $prof = new App_Model_Profesion();        
        $e = new Zend_Form_Element_Select('idProfesion');        
        $e->setMultiOptions(array("0" => "--- Seleccionar ---") + $prof->listarProfesiones());
        $e->setRegisterInArrayValidator(false);
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Select('idEspecialidad');
        $e->setMultiOptions(array("0" => "--- Seleccionar ---"));
        $e->setRegisterInArrayValidator(false);
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Select('idSubEspecialidad');
        $e->setMultiOptions(array("0" => "--- Seleccionar ---"));
        $e->setRegisterInArrayValidator(false);
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Radio('tipo');
        $e->addMultiOptions(array(
            '1' => ' Oferente (Personal estable de la empresa)',
            '2' => ' Contratado')
        );
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('expanos');
        $e->setFilters(array("StripTags", "StringTrim"));        
        $e->setAttrib('size', '1');
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Select('expmeses');
        $e->addMultiOption('1', '1')
            ->addMultiOption('2', '2')
            ->addMultiOption('3', '3')
            ->addMultiOption('4', '4')
            ->addMultiOption('5', '5')
            ->addMultiOption('6', '6')
            ->addMultiOption('7', '7')
            ->addMultiOption('8', '8')
            ->addMultiOption('9', '9')
            ->addMultiOption('10', '10')
            ->addMultiOption('11', '11')
            ->addMultiOption('12', '12');
        
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