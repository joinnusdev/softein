alter table `empresa` change `nroDocumento` `nroDocumento` int(12) NULL ;

alter table `empresa` change `fechaConstitucion` `fechaConstitucion` date NULL ;

alter table `empresa` add column `confirmar` varchar(50) NULL COMMENT 'Confirmacion por correo' after `otros`;

alter table `empresa` change `nroDocumento` `numeroDocumento` int(12) NULL ;
alter table `empresa` change `numeroDocumento` `numeroDocumento` varchar(12) NULL ;