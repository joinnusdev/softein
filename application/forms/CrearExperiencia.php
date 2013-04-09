<?php

class App_Form_CrearExperiencia extends App_Form
{
    public function init() {
        
        parent::init();
        
        /*========================= DATOS DEL REGISTRO ==========================*/
        
        
        $e = new Zend_Form_Element_Text('idDetalleEmpresa');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('servicioNombre');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('servicioPais');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('servicioRuc');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired();
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('fechaInicio');
        $e->setAttrib('class', 'span12');
        $e->setRequired(true);
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Text('fechaFin');
        $e->setAttrib('class', 'span12');
        $e->setRequired(true);
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Checkbox("enCurso", array("checked" => "checked"));
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Textarea('observacion');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('montoTotal');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('referenciaNombre');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('referenciaCargo');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('referenciaTelefono');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('referenciaEmail');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $v = new Zend_Validate_EmailAddress();
        $e->addValidator($v);
        $e->setRequired(true);
        $e->addFilter(new Zend_Filter_HtmlEntities());
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