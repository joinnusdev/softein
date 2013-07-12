<?php

class App_Form_CriteriosEvaluacion extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idCriterioEvaluacion');        
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('cargo');    
        $e->setAttrib('required', 'required');
        $e->setAttrib('size', '50');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Select('nivelAcademico');
        $e->setAttrib('class', 'required');
        $e->addMultiOption('Doctorado', 'Doctorado')
            ->addMultiOption('Maestria', 'Maestria')
            ->addMultiOption('Titulado', 'Titulado')
            ->addMultiOption('Bachiller', 'Bachiller');
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        $prof = new App_Model_Profesion();        
        $e = new Zend_Form_Element_Multiselect('idProfesion');
        $e->setMultiOptions($prof->listarProfesiones());
        
        $e->setRegisterInArrayValidator(false);
        $e->setAttrib('required', 'required');
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Multiselect('idEspecialidad');
        //$e->setMultiOptions();
        $e->setRegisterInArrayValidator(false);
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Select('idSubEspecialidad');
        $e->setMultiOptions(array("0" => "--- Seleccionar ---"));        
        $e->setRegisterInArrayValidator(false);
        $e->setAttrib('class', 'span5');
        $this->addElement($e);
        
        
        
        $e = new Zend_Form_Element_Text('experienciaGeneralAnos');
        $e->setFilters(array("StripTags", "StringTrim"));        
        
        $e->setAttrib('size', '1');
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '2');
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Select('experienciaGeneralMeses');
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
        
        $e = new Zend_Form_Element_Textarea('descripcionExperienciaEspecifica');        
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
}