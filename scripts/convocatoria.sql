create table `cempresa`( `idConvocatoriaExperiencia` int(7) UNSIGNED NOT NULL AUTO_INCREMENT , `idConvocatoria` int(7) UNSIGNED NOT NULL , `codigo` char(15) NOT NULL , `fechaRegistro` datetime , `idEmpresa` int(7) UNSIGNED NOT NULL , PRIMARY KEY (`idConvocatoriaExperiencia`))  ;

create table `detaexperiencia`( `idDetalleExperiencia` int(7) UNSIGNED NOT NULL AUTO_INCREMENT , `idConvocatoriaExperiencia` int(7) UNSIGNED NOT NULL , `idExperiencia` int(7) UNSIGNED NOT NULL , PRIMARY KEY (`idDetalleExperiencia`))  ;

create table `detapersona`( `idDetallePersonal` int(7) UNSIGNED NOT NULL AUTO_INCREMENT , `idConvocatoriaExperiencia` int(7) UNSIGNED NOT NULL , `idPersonal` int(7) UNSIGNED NOT NULL , PRIMARY KEY (`idDetallePersonal`))  ;