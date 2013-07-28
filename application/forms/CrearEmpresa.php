<?php

class App_Form_CrearEmpresa extends App_Form
{
    public function init() {
        
        parent::init();
        
        /*========================= DATOS DEL REGISTRO ==========================*/
        
        $e = new Zend_Form_Element_Text('idEmpresa');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        
        $modelPais = new App_Model_Pais();
        $listaPais = $modelPais->listarPair();
        
        $this->addElement(new Zend_Form_Element_Select('paisEmpresa'));
        $this->getElement('paisEmpresa')->addMultiOption('0', '-- Seleccione Pais --');
        $this->getElement('paisEmpresa')->addMultiOptions($listaPais);
        $this->getElement('paisEmpresa')->setAttrib('class', 'required');
        $this->getElement('paisEmpresa')->setRequired(); 
        
        
        
        $this->addElement(new Zend_Form_Element_Select('tipoDocumento'));
        $this->getElement('tipoDocumento')->addMultiOption('', 'Seleccione Documento');
        $this->getElement('tipoDocumento')->addMultiOption('2', 'RUC');
        /* $this->getElement('tipoDocumento')->addMultiOption('1', 'Pasaporte');
        $this->getElement('tipoDocumento')->addMultiOption('3', 'DNI')*/
        $this->getElement('tipoDocumento')->addMultiOption('4', 'Otros Internacional');
        $this->getElement('tipoDocumento')->setAttrib('class', 'required');
        $this->getElement('tipoDocumento')->setRequired();
        $this->getElement('tipoDocumento')->removeDecorator('htmlTag');
        $this->getElement('tipoDocumento')->removeDecorator('Errors');
        
        
        $e = new Zend_Form_Element_Text('numeroDocumento');
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '11');
        $e->setAttrib('maxlength', '11');
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
        $e->setAttrib('size', '40');
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
        $e->setAttrib('minlength', '8');
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>5,'max'=>30));
        $e->addValidator($v);
        $this->addElement($e);
        
  
        $e = new Zend_Form_Element_Text('clavesita');
        $e->setAttrib('class', 'required');
        $e->setAttrib('minlength', '8');
        $v = new Zend_Validate_StringLength(array('min'=>5,'max'=>30));
        $e->addValidator($v);
        $this->addElement($e);
                
        
        
        
        /*========================= DATOS DEL COMPLEMENTARIOS ==========================*/
        
        $e = new Zend_Form_Element_Text('cantEmpleados');
        $e->setAttrib('size', '3');
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '4');
        
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('fechaConstitucion');
        $e->setAttrib('class', 'required');
        $e->setRequired(true);
        //$e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Text('aniosExperiencia');
        $e->setAttrib('size', '3');
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '1');
        $e->setAttrib('maxlength', '3');
        
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nroFicha');
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '10');
        $e->setAttrib('maxlength', '10');
        
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        
        /*========================  ADICIONALES =======================*/
        
        //GIRO
        
        
        //SUBIR PDF CON COPIA DE SU RUC DE SUNAT, EL RUC ES EL NOMBRE DEL ARCHVIO
        /*$e = new Zend_Form_Element_File('pdfRuc');        
        $config = Zend_Registry::get('config');
        $ruta = $config->app->mediaRoot;
        $e->setDestination($ruta);
        $this->addElement($e);
        */
        
        $e = new Zend_Form_Element_Text('fax');
        $e->setAttrib('class', 'number');
        $e->setAttrib('minlength', '7');
        
        
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('url');
        $e->setAttrib('class', 'url');
        $e->setAttrib('size', '60');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        
        $this->addElement(new Zend_Form_Element_Select('tipoOrganizacion'));
        $this->getElement('tipoOrganizacion')->addMultiOption('', 'Seleccione');
        $this->getElement('tipoOrganizacion')->addMultiOption('sac', 'Sociedad Anonima Cerrada');
        $this->getElement('tipoOrganizacion')->addMultiOption('srl', 'Sociedad de Responsabilidad Limitada');
        $this->getElement('tipoOrganizacion')->addMultiOption('ong', 'Organización no Gubernamental');
        $this->getElement('tipoOrganizacion')->addMultiOption('ie', 'Institución del Estado');
        $this->getElement('tipoOrganizacion')->setAttrib('class', 'required');
        $this->getElement('tipoOrganizacion')->setRequired();
        $this->getElement('tipoOrganizacion')->removeDecorator('htmlTag');
        $this->getElement('tipoOrganizacion')->removeDecorator('Errors');
        
        $e = new Zend_Form_Element_Text('otros');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
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