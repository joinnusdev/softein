<?php

class App_Form_CrearProducto extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idProducto');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nombreProducto');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('precio');
        $e->setRequired(true);
        $v = new Zend_Validate_Float();
        $e->addValidator($v);
        $e->setFilters(array("StripTags", "StringTrim", "HtmlEntities"));
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_File('foto');        
        $config = Zend_Registry::get('config');
        $ruta = $config->app->mediaRoot;
        $e->setDestination($ruta);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Guardar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);
        
        $this->addElement('hash', 'csrf');
        
         foreach($this->getElements() as $e) {
            $e->removeDecorator('DtDdWrapper');
            $e->removeDecorator('Label');
            $e->removeDecorator('HtmlTag');
        } 
        
        
        
    }
}