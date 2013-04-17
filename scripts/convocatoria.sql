create table `cempresa`( `idConvocatoriaExperiencia` int(7) UNSIGNED NOT NULL AUTO_INCREMENT , `idConvocatoria` int(7) UNSIGNED NOT NULL , `codigo` char(15) NOT NULL , `fechaRegistro` datetime , `idEmpresa` int(7) UNSIGNED NOT NULL , PRIMARY KEY (`idConvocatoriaExperiencia`))  ;

create table `detaexperiencia`( `idDetalleExperiencia` int(7) UNSIGNED NOT NULL AUTO_INCREMENT , `idConvocatoriaExperiencia` int(7) UNSIGNED NOT NULL , `idExperiencia` int(7) UNSIGNED NOT NULL , PRIMARY KEY (`idDetalleExperiencia`))  ;

create table `detapersonal`( `idDetallePersonal` int(7) UNSIGNED NOT NULL AUTO_INCREMENT , `idConvocatoriaExperiencia` int(7) UNSIGNED NOT NULL , `idPersonal` int(7) UNSIGNED NOT NULL , PRIMARY KEY (`idDetallePersonal`))  ;

alter table `cempresa` add column `estado` tinyint(1) NULL after `idEmpresa`;

create table `personal`( `idPersonal` int(7) UNSIGNED NOT NULL AUTO_INCREMENT , `nombre` varchar(50) , `apellido` varchar(50) , `cargo` varchar(100) , `email` varchar(100) , `telefono` char(12) , `nivelacademico` varchar(30) , `tipo` tinyint(1) , `expanos` char(10) , `expmeses` char(10) , `fechaRegistro` datetime , `estado` tinyint(1) DEFAULT '1' , PRIMARY KEY (`idPersonal`))  ;