create table `referencia`( `idReferencia` int(11) UNSIGNED NOT NULL AUTO_INCREMENT , `idEmpresa` int(11) UNSIGNED NOT NULL , `nombre` char(100) CHARSET utf8 COLLATE utf8_spanish_ci , `email` char(50) CHARSET utf8 COLLATE utf8_spanish_ci , `telefono` char(10) CHARSET utf8 COLLATE utf8_spanish_ci , `cargo` varchar(50) CHARSET utf8 COLLATE utf8_spanish_ci , `estado` char(1) DEFAULT '1' , PRIMARY KEY (`idReferencia`))  ;

alter table `referencia` add column `apellido` char(100) CHARSET utf8 COLLATE utf8_spanish_ci NULL after `nombre`,change `nombre` `nombre` char(100) character set utf8 collate utf8_spanish_ci NULL ;

alter table `referencia` add column `fechaRegistro` datetime NULL after `estado`;

alter table `detalleempresa` add column `idPersonal` int(11) DEFAULT '0' NULL after `idEmpresa`;

alter table `detalleempresa` change `idEmpresa` `idEmpresa` int(11) default '0' NULL ;