ALTER TABLE `personal` 
   ADD COLUMN `numerodocumento` CHAR(15) NULL AFTER `estado`;


insert into `empresa`(`idEmpresa`,`paisEmpresa`,`tipoDocumento`,`numeroDocumento`,`nombreEmpresa`,`representanteLegal`,`email`,`telefono`,`clave`,`fechaRegistro`,`estado`,`fechaUltimoAcceso`,`ultimaIp`,`tipoUsuario`,`cantEmpleados`,`fechaConstitucion`,`aniosExperiencia`,`nroFicha`,`pdfRuc`,`fax`,`url`,`tipoOrganizacion`,`otros`,`confirmar`) values 
( NULL,'Perú','1','67171717171','james','otiniano','admin@admin.com','98987867',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);