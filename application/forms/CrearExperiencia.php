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
        $e->setAttrib('class', 'required');
        $e->setAttrib('size', '50');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        
        $modelPais = new App_Model_Pais();
        $listaPais = $this->fetchPairs($modelPais->listarPais());
        
        $this->addElement(new Zend_Form_Element_Select('servicioPais'));
        $this->getElement('servicioPais')->addMultiOption('', 'Seleccione Pais');
        $this->getElement('servicioPais')->addMultiOptions($listaPais);
        $this->getElement('servicioPais')->setAttrib('class', 'required');
        $this->getElement('servicioPais')->setRequired(); 
        
        
        $e = new Zend_Form_Element_Text('servicioRuc');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '12');
        $e->setAttrib('maxlength', '12');
        $e->setRequired();
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('fechaInicio');
        $e->setAttrib('class', 'required');
        
        $e->setRequired(true);
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Text('fechaFin');
        $e->setRequired(true);
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Checkbox("enCurso", array("checked" => "checked"));
        $this->addElement($e);
        //$e = new Zend_Form_Element_Checkbox("enCurso", array("checked" => "checked")
        
        
        $e = new Zend_Form_Element_Textarea('observacion');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setAttrib('cols', '50');
        $e->setAttrib('rows', '3');
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Textarea('descripcion');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setAttrib('cols', '50');
        $e->setAttrib('rows', '3');
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('montoTotal');
        $e->setAttrib('class', 'number');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('referenciaNombre'); 
        $e->setAttrib('size', '40');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('referenciaCargo');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('referenciaTelefono');
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '8');
        $e->setAttrib('maxlength', '11');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('referenciaEmail');
        $e->setAttrib('size', '40');
        $e->setAttrib('class', 'email');
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