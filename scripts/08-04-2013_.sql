/*
SQLyog Enterprise - MySQL GUI v8.02 RC
MySQL - 5.5.15-log : Database - modulos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`modulos` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `modulos`;

/*Table structure for table `contacto` */

DROP TABLE IF EXISTS `contacto`;

CREATE TABLE `contacto` (
  `idContacto` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(80) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefono` int(10) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `fechaRegistro` date DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  PRIMARY KEY (`idContacto`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `contacto` */

LOCK TABLES `contacto` WRITE;

insert  into `contacto`(`idContacto`,`idEmpresa`,`nombre`,`apellido`,`email`,`telefono`,`cargo`,`fechaRegistro`,`estado`) values (10,1,'Adrian','galvez robles','nuevo@nuevo.com',987255000,'Gerente de Ventas','2013-04-07','1'),(11,1,'Marina','Rivera zevallos','mariana@gmail.com',1234567888,'Administrador de ventas','2013-04-07','1');

UNLOCK TABLES;

/*Table structure for table `detalleempresa` */

DROP TABLE IF EXISTS `detalleempresa`;

CREATE TABLE `detalleempresa` (
  `idDetalleEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `servicioNombre` varchar(80) DEFAULT NULL COMMENT 'Empresa servicio nombre',
  `servicioPais` varchar(60) DEFAULT NULL COMMENT 'Empresa servicio pais',
  `servicioRuc` int(12) DEFAULT NULL COMMENT 'Empresa servicio RUc',
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `enCurso` char(1) DEFAULT NULL,
  `observacion` text,
  `montoTotal` decimal(10,2) DEFAULT NULL,
  `descripcion` text,
  `referenciaNombre` varchar(50) DEFAULT NULL,
  `referenciaCargo` varchar(100) DEFAULT NULL,
  `referenciaTelefono` int(12) DEFAULT NULL,
  `referenciaEmail` varchar(50) DEFAULT NULL,
  `idEmpresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDetalleEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `detalleempresa` */

LOCK TABLES `detalleempresa` WRITE;

insert  into `detalleempresa`(`idDetalleEmpresa`,`servicioNombre`,`servicioPais`,`servicioRuc`,`fechaInicio`,`fechaFin`,`enCurso`,`observacion`,`montoTotal`,`descripcion`,`referenciaNombre`,`referenciaCargo`,`referenciaTelefono`,`referenciaEmail`,`idEmpresa`) values (1,'Innova','Peru',2147483647,'2013-03-01','2013-04-02','0',NULL,'50000.00',NULL,'jerymi','gerente de operaciones',NULL,'jerimi@gmail.com',1),(2,'El Comercio','Peru',2147483647,'0000-00-00','0000-00-00','0',NULL,'500000.00',NULL,'Ramiro gonzales prada','gerente de operaciones',NULL,'ramiro@gmail.com',1),(3,'3DEV','Peru',2147483647,'2012-11-05','0000-00-00','1',NULL,'0.00',NULL,'Rosa rosales claveles','Gerente de operaciones',NULL,'rosa@gmail.com',1);

UNLOCK TABLES;

/*Table structure for table `empresa` */

DROP TABLE IF EXISTS `empresa`;

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `paisEmpresa` varchar(120) DEFAULT NULL,
  `tipoDocumento` int(11) DEFAULT NULL,
  `nroDocumento` int(11) DEFAULT NULL,
  `nombreEmpresa` varchar(100) DEFAULT NULL,
  `representanteLegal` varchar(100) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `telefono` int(10) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `fechaUltimoAcceso` datetime DEFAULT NULL,
  `ultimaIp` char(50) DEFAULT NULL,
  `tipoUsuario` int(1) DEFAULT NULL,
  `cantEmpleados` int(20) DEFAULT NULL,
  `fechaConstitucion` datetime DEFAULT NULL,
  `aniosExperiencia` int(10) DEFAULT NULL,
  `nroFicha` int(30) DEFAULT NULL,
  `pdfRuc` varchar(50) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `tipoOrganizacion` varchar(80) DEFAULT NULL,
  `otros` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `empresa` */

LOCK TABLES `empresa` WRITE;

insert  into `empresa`(`idEmpresa`,`paisEmpresa`,`tipoDocumento`,`nroDocumento`,`nombreEmpresa`,`representanteLegal`,`email`,`telefono`,`clave`,`fechaRegistro`,`estado`,`fechaUltimoAcceso`,`ultimaIp`,`tipoUsuario`,`cantEmpleados`,`fechaConstitucion`,`aniosExperiencia`,`nroFicha`,`pdfRuc`,`fax`,`url`,`tipoOrganizacion`,`otros`) values (1,'Perú',1,2147483647,'Steve sac','yo mismo','jsteve.villano@gmail.com',987255127,'e10adc3949ba59abbe56e057f20f883e','2013-04-07 15:02:21','1','2013-04-08 11:11:58','127.0.0.1',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,'EEUU',1,2147483647,'USA SAC','Julio Roman Riquelme','roman@gmail.com',987654323,'e10adc3949ba59abbe56e057f20f883e','2013-04-07 20:47:39','2','2013-04-08 11:13:58','127.0.0.1',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:01:28','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:02:31','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(31,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:03:10','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(32,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:04:46','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(33,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:04:49','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(34,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:10:24','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(35,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:10:32','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(36,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:11:04','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(37,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:12:49','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(38,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:12:52','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-08 12:13:03','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

UNLOCK TABLES;

/*Table structure for table `pmsj_convoca` */

DROP TABLE IF EXISTS `pmsj_convoca`;

CREATE TABLE `pmsj_convoca` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL DEFAULT '',
  `compo` varchar(200) DEFAULT NULL,
  `proceso` varchar(250) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `limite` date NOT NULL DEFAULT '0000-00-00',
  `texto` text,
  `atdr` varchar(60) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT '1',
  `aresp` varchar(60) DEFAULT NULL,
  `aresul` varchar(60) DEFAULT NULL,
  `aabsol` varchar(60) DEFAULT NULL,
  `ainfo` varchar(60) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `codpaac` varchar(20) DEFAULT NULL,
  `idpoa` int(11) DEFAULT NULL,
  `idprimera` int(11) DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `proceso` (`proceso`),
  KEY `fecha` (`limite`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `pmsj_convoca` */

LOCK TABLES `pmsj_convoca` WRITE;

insert  into `pmsj_convoca`(`ID`,`codigo`,`compo`,`proceso`,`fecha`,`limite`,`texto`,`atdr`,`estado`,`aresp`,`aresul`,`aabsol`,`ainfo`,`tipo`,`codpaac`,`idpoa`,`idprimera`) values (1,'CF-10',NULL,'Contratación de una firma consultora para la implementación de una línea de producción de microformas en la UC','2011-05-15','2011-05-25',NULL,'files/LPM_UCP.pdf',2,NULL,NULL,NULL,NULL,2,'CF-10',NULL,1);

UNLOCK TABLES;

/*Table structure for table `servicio` */

DROP TABLE IF EXISTS `servicio`;

CREATE TABLE `servicio` (
  `idservicio` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `nombreServicio` varchar(50) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  PRIMARY KEY (`idservicio`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='																				\n\n';

/*Data for the table `servicio` */

LOCK TABLES `servicio` WRITE;

insert  into `servicio`(`idservicio`,`nombreServicio`,`estado`) values (1,'servicio 1','1'),(2,'servicio 2 editado','1'),(4,'servicio 3','1'),(5,'servicio 4','1'),(6,'servicio 5','1'),(7,'servicio 6','1'),(8,'servicio 7','1'),(9,'servicio 8','1'),(10,'servicio 9','1'),(11,'servicio 10','0'),(12,'servicio 11','1');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
