<?php

class App_Form_CrearServicio extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idservicio');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nombreServicio');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Guardar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);
        
        
        $this->addElement('hash', 'csrf', array(
                    'ignore' => true,
                ));
         foreach($this->getElements() as $e) {
            $e->removeDecorator('DtDdWrapper');
            $e->removeDecorator('Label');
            $e->removeDecorator('HtmlTag');
        } 
        
        
        
    }
}