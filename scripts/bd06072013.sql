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

/*Table structure for table `cempresa` */

DROP TABLE IF EXISTS `cempresa`;

CREATE TABLE `cempresa` (
  `idConvocatoriaExperiencia` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `idConvocatoria` int(7) unsigned NOT NULL,
  `codigo` char(6) NOT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `idEmpresa` int(7) unsigned NOT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idConvocatoriaExperiencia`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `cempresa` */

insert  into `cempresa`(`idConvocatoriaExperiencia`,`idConvocatoria`,`codigo`,`fechaRegistro`,`idEmpresa`,`estado`) values (1,1,'1-41-P','2013-04-21 00:46:28',41,2),(2,1,'1-1-XR','2013-04-21 01:32:46',1,2),(3,1,'1-42-W','2013-04-29 23:44:28',42,2),(4,260,'260-1-','2013-05-15 17:58:22',1,2),(5,261,'261-1-','2013-06-24 19:38:30',1,2);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `contacto` */

insert  into `contacto`(`idContacto`,`idEmpresa`,`nombre`,`apellido`,`email`,`telefono`,`cargo`,`fechaRegistro`,`estado`) values (10,1,'Adrian','galvez robles','nuevo@nuevo.com',987255000,'Gerente de Ventas','2013-04-07','0'),(11,1,'Marina','Rivera zevallos','mariana@gmail.com',1234567888,'Administrador de ventas','2013-04-07','1'),(13,43,'kjndaskjh',',ndask','nuevo@nuevo.com',87676646,'kjdaskjh','2013-05-19','1'),(14,43,',ndsjadbhk','kjfdkjfkjdsg','sysnotaria@gmail.com',87687652,'aasas','2013-05-19','1'),(16,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1');

/*Table structure for table `criterioevaluacion` */

DROP TABLE IF EXISTS `criterioevaluacion`;

CREATE TABLE `criterioevaluacion` (
  `idCriterioEvaluacion` int(11) NOT NULL AUTO_INCREMENT,
  `idCriterio` int(11) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `nivelAcademico` varchar(50) DEFAULT NULL,
  `idProfesion` int(11) DEFAULT NULL,
  `idEspecialidad` int(11) DEFAULT NULL,
  `idSubEspecialidad` int(11) DEFAULT NULL,
  `experienciaGeneralAnos` int(2) DEFAULT NULL,
  `experienciaGeneralMeses` int(3) DEFAULT NULL,
  `descripcionExperienciaEspecifica` text,
  PRIMARY KEY (`idCriterioEvaluacion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `criterioevaluacion` */

insert  into `criterioevaluacion`(`idCriterioEvaluacion`,`idCriterio`,`cargo`,`nivelAcademico`,`idProfesion`,`idEspecialidad`,`idSubEspecialidad`,`experienciaGeneralAnos`,`experienciaGeneralMeses`,`descripcionExperienciaEspecifica`) values (1,1,'prueba Gestor de Proyectos','Titulado',2,4,8,8,7,'gola'),(2,1,'Gerente de Ventas','Titulado',2,3,5,1,4,'d');

/*Table structure for table `criterioseleccion` */

DROP TABLE IF EXISTS `criterioseleccion`;

CREATE TABLE `criterioseleccion` (
  `idCriterio` int(11) NOT NULL AUTO_INCREMENT,
  `idConvocatoria` int(11) DEFAULT NULL,
  `antiguedadEmpresa` int(3) DEFAULT NULL,
  `puntajeAntiguedad` int(2) DEFAULT NULL,
  `montoMinimo` decimal(8,2) DEFAULT NULL,
  `puntajeMonto` int(2) DEFAULT NULL,
  `anosMontoMinimo` int(3) DEFAULT NULL,
  `experienciaEspecificaAnos` int(3) DEFAULT NULL,
  `experienciaEspecificaMeses` int(2) DEFAULT NULL,
  `puntajeExperienciaEspecifica` int(2) DEFAULT NULL,
  `experienciaGeneralAnos` int(3) DEFAULT NULL,
  `experienciaGeneralMeses` int(2) DEFAULT NULL,
  `puntajeExperienciaGeneral` int(2) DEFAULT NULL,
  `resumenExperiencia` text,
  PRIMARY KEY (`idCriterio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `criterioseleccion` */

insert  into `criterioseleccion`(`idCriterio`,`idConvocatoria`,`antiguedadEmpresa`,`puntajeAntiguedad`,`montoMinimo`,`puntajeMonto`,`anosMontoMinimo`,`experienciaEspecificaAnos`,`experienciaEspecificaMeses`,`puntajeExperienciaEspecifica`,`experienciaGeneralAnos`,`experienciaGeneralMeses`,`puntajeExperienciaGeneral`,`resumenExperiencia`) values (1,261,10,1,'1.00',1,3,1,1,1,1,1,1,'1prueba1');

/*Table structure for table `detaexperiencia` */

DROP TABLE IF EXISTS `detaexperiencia`;

CREATE TABLE `detaexperiencia` (
  `idDetalleExperiencia` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `idConvocatoriaExperiencia` int(7) unsigned NOT NULL,
  `idExperiencia` int(7) unsigned NOT NULL,
  PRIMARY KEY (`idDetalleExperiencia`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `detaexperiencia` */

insert  into `detaexperiencia`(`idDetalleExperiencia`,`idConvocatoriaExperiencia`,`idExperiencia`) values (2,1,6),(5,2,4),(6,2,5),(14,3,7),(15,1,4),(16,1,5),(17,1,4),(18,1,5),(21,5,4);

/*Table structure for table `detalleempresa` */

DROP TABLE IF EXISTS `detalleempresa`;

CREATE TABLE `detalleempresa` (
  `idDetalleEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `servicioNombre` varchar(80) DEFAULT NULL COMMENT 'Empresa servicio nombre',
  `servicioPais` varchar(60) DEFAULT NULL COMMENT 'Empresa servicio pais',
  `servicioRuc` varchar(12) DEFAULT NULL COMMENT 'Empresa servicio RUc',
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
  `idEmpresa` int(11) DEFAULT '0',
  `idPersonal` int(11) DEFAULT '0',
  PRIMARY KEY (`idDetalleEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `detalleempresa` */

insert  into `detalleempresa`(`idDetalleEmpresa`,`servicioNombre`,`servicioPais`,`servicioRuc`,`fechaInicio`,`fechaFin`,`enCurso`,`observacion`,`montoTotal`,`descripcion`,`referenciaNombre`,`referenciaCargo`,`referenciaTelefono`,`referenciaEmail`,`idEmpresa`,`idPersonal`) values (1,'Innova','Peru','2147483647','2013-03-01','2013-04-02','0',NULL,'50000.00',NULL,'jerymi','gerente de operaciones',NULL,'jerimi@gmail.com',1,0),(2,'El Comercio','Peru','2147483647','0000-00-00','0000-00-00','0',NULL,'500000.00',NULL,'Ramiro gonzales prada','gerente de operaciones',NULL,'ramiro@gmail.com',1,0),(3,'3DEV','Peru','2147483647','2012-11-05','0000-00-00','1',NULL,'0.00',NULL,'Rosa rosales claveles','Gerente de operaciones',NULL,'rosa@gmail.com',1,0),(4,'las ricas','173','104517196911','2013-04-16','2013-04-30','1','nuevas','8000.00','empresas','yooo ','',0,'',1,0),(5,'noene','173','106718189811','2013-04-16','2013-04-30','1','nuevo','90000.00','nuevo','nuevo ','jaja',999991111,'nuevo@gmail.com',1,0),(6,'dsad','3','889789789333','2013-04-19','2013-04-27','1','dsad','8678.00','lkjhdskjahkdjas','dasda','uijdasgh',766763233,'ewew@fds.com',41,0),(7,'njhkads','173','10451719690','2013-04-01','2013-04-30','1','fdas','2121.00','fdfds','nuevo ','jaja',786756111,'nuevo@gmail.com',42,0),(9,'jdhjdg1','173','10451719691','2013-05-01','2013-05-17','1',',jbdkasjgbfkj111','6714.00','kjhkjfgkfjsdgfjks11','kfjhfkjsh11','hfg1',2147483647,'nuev1oa@gmail.com',43,0),(10,'lololo','173','11111111111','2013-05-02','2013-05-03','1','lolololo','111.00','lolololo','loololo','lolololo',121212121,'lala@klj.com',0,5),(11,'lilili','4','89786756671','2013-05-01','2013-05-31','0','kjdhsadh','898.00','udhsudfshyiu','compl','jefe',897868767,'email@gmail.com',0,5),(12,'mivida','173','22222222222','2013-03-13','2013-07-17','1','fff','500.00','ff','','',0,'',0,7),(13,'legolas','173','11111111111','2013-07-01','2013-06-01','1','f','500000.00','f','','',0,'',1,0),(14,'legolas','173','11111111111','2013-06-01','2013-05-01','1','fggfgf','0.00','','','',0,'',1,0);

/*Table structure for table `detapersona` */

DROP TABLE IF EXISTS `detapersona`;

CREATE TABLE `detapersona` (
  `idDetallePersonal` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `idConvocatoriaExperiencia` int(7) unsigned NOT NULL,
  `idPersonal` int(7) unsigned NOT NULL,
  PRIMARY KEY (`idDetallePersonal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `detapersona` */

/*Table structure for table `detapersonal` */

DROP TABLE IF EXISTS `detapersonal`;

CREATE TABLE `detapersonal` (
  `idDetallePersonal` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `idConvocatoriaExperiencia` int(7) unsigned NOT NULL,
  `idPersonal` int(7) unsigned NOT NULL,
  PRIMARY KEY (`idDetallePersonal`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `detapersonal` */

insert  into `detapersonal`(`idDetallePersonal`,`idConvocatoriaExperiencia`,`idPersonal`) values (1,2,1),(19,3,2),(20,4,1);

/*Table structure for table `empresa` */

DROP TABLE IF EXISTS `empresa`;

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `paisEmpresa` varchar(120) DEFAULT NULL,
  `tipoDocumento` int(11) DEFAULT NULL,
  `numeroDocumento` varchar(12) DEFAULT NULL,
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
  `fechaConstitucion` date DEFAULT NULL,
  `aniosExperiencia` int(10) DEFAULT NULL,
  `nroFicha` int(30) DEFAULT NULL,
  `pdfRuc` varchar(50) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `tipoOrganizacion` varchar(80) DEFAULT NULL,
  `otros` varchar(100) DEFAULT NULL,
  `confirmar` varchar(50) DEFAULT NULL COMMENT 'Confirmacion por correo',
  `consorcio` int(11) DEFAULT '0',
  PRIMARY KEY (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

/*Data for the table `empresa` */

insert  into `empresa`(`idEmpresa`,`paisEmpresa`,`tipoDocumento`,`numeroDocumento`,`nombreEmpresa`,`representanteLegal`,`email`,`telefono`,`clave`,`fechaRegistro`,`estado`,`fechaUltimoAcceso`,`ultimaIp`,`tipoUsuario`,`cantEmpleados`,`fechaConstitucion`,`aniosExperiencia`,`nroFicha`,`pdfRuc`,`fax`,`url`,`tipoOrganizacion`,`otros`,`confirmar`,`consorcio`) values (1,'173',2,'21474836471','Steve sac','yo mismo','jsteve.villano@gmail.com',987255127,'25d55ad283aa400af464c76d713c07ad','2013-04-07 15:02:21','1','2013-07-06 12:24:36','127.0.0.1',1,0,'2010-05-15',3,1234567876,NULL,'','','sac','',NULL,0),(28,'EEUU',1,'2147483647','USA SAC','Julio Roman Riquelme','roman@gmail.com',987654323,'25d55ad283aa400af464c76d713c07ad','2013-04-07 20:47:39','1','2013-06-24 12:45:32','127.0.0.1',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(40,'Perú',1,'67171717171','james','otiniano','admin@admin.com',98987867,'25d55ad283aa400af464c76d713c07ad','2013-04-01 20:00:00','1','2013-07-06 12:24:15','127.0.0.1',2,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(41,'peru',1,'89789789789','sacc','sacc','sac@sac.com',894732,'25d55ad283aa400af464c76d713c07ad',NULL,'1','2013-04-21 00:37:15','127.0.0.1',1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(42,'173',2,'10451719690','Nueva','Nuevo','james.otiniano@gmail.com',909898789,'25d55ad283aa400af464c76d713c07ad','2013-04-29 23:38:16','1','2013-05-02 23:57:30','127.0.0.1',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'6c11cb78b7bbb5c',0),(43,'Perú',2,'10474747490','consorcioe','representantee','lala@gmail.com',133987891,NULL,'2013-01-01 21:21:21','1','2013-01-01 21:21:21','127.0.0.1',1,1,'2013-01-02',11,1121212121,'21','3213123','http://dasds.com','ie','lololo',NULL,1),(44,'Perú',2,'21474836471','nanan','nanana','admin1@admin.com',676767676,'25d55ad283aa400af464c76d713c07ad',NULL,NULL,'2013-05-18 14:14:44',NULL,NULL,1,'2013-05-04',2,2147483647,NULL,'76432674527','http://dasds.com','ie','khfsdkughf',NULL,1);

/*Table structure for table `especialidad` */

DROP TABLE IF EXISTS `especialidad`;

CREATE TABLE `especialidad` (
  `idEspecialidad` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `idProfesion` int(4) unsigned NOT NULL,
  `descripcion` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `general` char(1) DEFAULT NULL,
  PRIMARY KEY (`idEspecialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `especialidad` */

insert  into `especialidad`(`idEspecialidad`,`idProfesion`,`descripcion`,`general`) values (1,1,'Criminal',NULL),(2,1,'Laboralista',NULL),(3,2,'Analista',NULL),(4,2,'Finanzas',NULL);

/*Table structure for table `pais` */

DROP TABLE IF EXISTS `pais`;

CREATE TABLE `pais` (
  `idPais` int(11) NOT NULL AUTO_INCREMENT,
  `pais_isonum` smallint(6) DEFAULT NULL,
  `pais_iso2` char(2) DEFAULT NULL,
  `pais_iso3` char(3) DEFAULT NULL,
  `pais` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`idPais`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;

/*Data for the table `pais` */

insert  into `pais`(`idPais`,`pais_isonum`,`pais_iso2`,`pais_iso3`,`pais`) values (1,4,'AF','AFG','Afganistan'),(2,248,'AX','ALA','Islas Gland'),(3,8,'AL','ALB','Albania'),(4,276,'DE','DEU','Alemania'),(5,20,'AD','AND','Andorra'),(6,24,'AO','AGO','Angola'),(7,660,'AI','AIA','Anguilla'),(8,10,'AQ','ATA','Antartida'),(9,28,'AG','ATG','Antigua y Barbuda'),(10,530,'AN','ANT','Antillas Holandesas'),(11,682,'SA','SAU','Arabia Saudí'),(12,12,'DZ','DZA','Argelia'),(13,32,'AR','ARG','Argentina'),(14,51,'AM','ARM','Armenia'),(15,533,'AW','ABW','Aruba'),(16,36,'AU','AUS','Australia'),(17,40,'AT','AUT','Austria'),(18,31,'AZ','AZE','Azerbaiyín'),(19,44,'BS','BHS','Bahamas'),(20,48,'BH','BHR','Bahráin'),(21,50,'BD','BGD','Bangladesh'),(22,52,'BB','BRB','Barbados'),(23,112,'BY','BLR','Bielorrusia'),(24,56,'BE','BEL','Bélgica'),(25,84,'BZ','BLZ','Belice'),(26,204,'BJ','BEN','Benin'),(27,60,'BM','BMU','Bermudas'),(28,64,'BT','BTN','Bhuton'),(29,68,'BO','BOL','Bolivia'),(30,70,'BA','BIH','Bosnia y Herzegovina'),(31,72,'BW','BWA','Botsuana'),(32,74,'BV','BVT','Isla Bouvet'),(33,76,'BR','BRA','Brasil'),(34,96,'BN','BRN','Brun?i'),(35,100,'BG','BGR','Bulgaria'),(36,854,'BF','BFA','Burkina Faso'),(37,108,'BI','BDI','Burundi'),(38,132,'CV','CPV','Cabo Verde'),(39,136,'KY','CYM','Islas Caim?n'),(40,116,'KH','KHM','Camboya'),(41,120,'CM','CMR','Camerún'),(42,124,'CA','CAN','Canadá'),(43,140,'CF','CAF','República Centroafricana'),(44,148,'TD','TCD','Chad'),(45,203,'CZ','CZE','República Checa'),(46,152,'CL','CHL','Chile'),(47,156,'CN','CHN','China'),(48,196,'CY','CYP','Chipre'),(49,162,'CX','CXR','Isla de Navidad'),(50,336,'VA','VAT','Ciudad del Vaticano'),(51,166,'CC','CCK','Islas Cocos'),(52,170,'CO','COL','Colombia'),(53,174,'KM','COM','Comoras'),(54,180,'CD','COD','Rep?blica Democr?tica del Congo'),(55,178,'CG','COG','Congo'),(56,184,'CK','COK','Islas Cook'),(57,408,'KP','PRK','Corea del Norte'),(58,410,'KR','KOR','Corea del Sur'),(59,384,'CI','CIV','Costa de Marfil'),(60,188,'CR','CRI','Costa Rica'),(61,191,'HR','HRV','Croacia'),(62,192,'CU','CUB','Cuba'),(63,208,'DK','DNK','Dinamarca'),(64,212,'DM','DMA','Dominica'),(65,214,'DO','DOM','Rep?blica Dominicana'),(66,218,'EC','ECU','Ecuador'),(67,818,'EG','EGY','Egipto'),(68,222,'SV','SLV','El Salvador'),(69,784,'AE','ARE','Emiratos ?rabes Unidos'),(70,232,'ER','ERI','Eritrea'),(71,703,'SK','SVK','Eslovaquia'),(72,705,'SI','SVN','Eslovenia'),(73,724,'ES','ESP','Espa?a'),(74,581,'UM','UMI','Islas ultramarinas de Estados Unidos'),(75,840,'US','USA','Estados Unidos'),(76,233,'EE','EST','Estonia'),(77,231,'ET','ETH','Etiop?a'),(78,234,'FO','FRO','Islas Feroe'),(79,608,'PH','PHL','Filipinas'),(80,246,'FI','FIN','Finlandia'),(81,242,'FJ','FJI','Fiyi'),(82,250,'FR','FRA','Francia'),(83,266,'GA','GAB','Gab?n'),(84,270,'GM','GMB','Gambia'),(85,268,'GE','GEO','Georgia'),(86,239,'GS','SGS','Islas Georgias del Sur y Sandwich del Sur'),(87,288,'GH','GHA','Ghana'),(88,292,'GI','GIB','Gibraltar'),(89,308,'GD','GRD','Granada'),(90,300,'GR','GRC','Grecia'),(91,304,'GL','GRL','Groenlandia'),(92,312,'GP','GLP','Guadalupe'),(93,316,'GU','GUM','Guam'),(94,320,'GT','GTM','Guatemala'),(95,254,'GF','GUF','Guayana Francesa'),(96,324,'GN','GIN','Guinea'),(97,226,'GQ','GNQ','Guinea Ecuatorial'),(98,624,'GW','GNB','Guinea-Bissau'),(99,328,'GY','GUY','Guyana'),(100,332,'HT','HTI','Hait?'),(101,334,'HM','HMD','Islas Heard y McDonald'),(102,340,'HN','HND','Honduras'),(103,344,'HK','HKG','Hong Kong'),(104,348,'HU','HUN','Hungr?a'),(105,356,'IN','IND','India'),(106,360,'ID','IDN','Indonesia'),(107,364,'IR','IRN','Ir?n'),(108,368,'IQ','IRQ','Iraq'),(109,372,'IE','IRL','Irlanda'),(110,352,'IS','ISL','Islandia'),(111,376,'IL','ISR','Israel'),(112,380,'IT','ITA','Italia'),(113,388,'JM','JAM','Jamaica'),(114,392,'JP','JPN','Jap?n'),(115,400,'JO','JOR','Jordania'),(116,398,'KZ','KAZ','Kazajst?n'),(117,404,'KE','KEN','Kenia'),(118,417,'KG','KGZ','Kirguist?n'),(119,296,'KI','KIR','Kiribati'),(120,414,'KW','KWT','Kuwait'),(121,418,'LA','LAO','Laos'),(122,426,'LS','LSO','Lesotho'),(123,428,'LV','LVA','Letonia'),(124,422,'LB','LBN','L?bano'),(125,430,'LR','LBR','Liberia'),(126,434,'LY','LBY','Libia'),(127,438,'LI','LIE','Liechtenstein'),(128,440,'LT','LTU','Lituania'),(129,442,'LU','LUX','Luxemburgo'),(130,446,'MO','MAC','Macao'),(131,807,'MK','MKD','ARY Macedonia'),(132,450,'MG','MDG','Madagascar'),(133,458,'MY','MYS','Malasia'),(134,454,'MW','MWI','Malawi'),(135,462,'MV','MDV','Maldivas'),(136,466,'ML','MLI','Mal?'),(137,470,'MT','MLT','Malta'),(138,238,'FK','FLK','Islas Malvinas'),(139,580,'MP','MNP','Islas Marianas del Norte'),(140,504,'MA','MAR','Marruecos'),(141,584,'MH','MHL','Islas Marshall'),(142,474,'MQ','MTQ','Martinica'),(143,480,'MU','MUS','Mauricio'),(144,478,'MR','MRT','Mauritania'),(145,175,'YT','MYT','Mayotte'),(146,484,'MX','MEX','M?xico'),(147,583,'FM','FSM','Micronesia'),(148,498,'MD','MDA','Moldavia'),(149,492,'MC','MCO','M?naco'),(150,496,'MN','MNG','Mongolia'),(151,500,'MS','MSR','Montserrat'),(152,508,'MZ','MOZ','Mozambique'),(153,104,'MM','MMR','Myanmar'),(154,516,'NA','NAM','Namibia'),(155,520,'NR','NRU','Nauru'),(156,524,'NP','NPL','Nepal'),(157,558,'NI','NIC','Nicaragua'),(158,562,'NE','NER','N?ger'),(159,566,'NG','NGA','Nigeria'),(160,570,'NU','NIU','Niue'),(161,574,'NF','NFK','Isla Norfolk'),(162,578,'NO','NOR','Noruega'),(163,540,'NC','NCL','Nueva Caledonia'),(164,554,'NZ','NZL','Nueva Zelanda'),(165,512,'OM','OMN','Om?n'),(166,528,'NL','NLD','Pa?ses Bajos'),(167,586,'PK','PAK','Pakist?n'),(168,585,'PW','PLW','Palau'),(169,275,'PS','PSE','Palestina'),(170,591,'PA','PAN','Panam?'),(171,598,'PG','PNG','Pap?a Nueva Guinea'),(172,600,'PY','PRY','Paraguay'),(173,604,'PE','PER','Perú'),(174,612,'PN','PCN','Islas Pitcairn'),(175,258,'PF','PYF','Polinesia Francesa'),(176,616,'PL','POL','Polonia'),(177,620,'PT','PRT','Portugal'),(178,630,'PR','PRI','Puerto Rico'),(179,634,'QA','QAT','Qatar'),(180,826,'GB','GBR','Reino Unido'),(181,638,'RE','REU','Reuni?n'),(182,646,'RW','RWA','Ruanda'),(183,642,'RO','ROU','Rumania'),(184,643,'RU','RUS','Rusia'),(185,732,'EH','ESH','Sahara Occidental'),(186,90,'SB','SLB','Islas Salom?n'),(187,882,'WS','WSM','Samoa'),(188,16,'AS','ASM','Samoa Americana'),(189,659,'KN','KNA','San Crist?bal y Nevis'),(190,674,'SM','SMR','San Marino'),(191,666,'PM','SPM','San Pedro y Miquel?n'),(192,670,'VC','VCT','San Vicente y las Granadinas'),(193,654,'SH','SHN','Santa Helena'),(194,662,'LC','LCA','Santa Luc?a'),(195,678,'ST','STP','Santo Tom? y Pr?ncipe'),(196,686,'SN','SEN','Senegal'),(197,891,'CS','SCG','Serbia y Montenegro'),(198,690,'SC','SYC','Seychelles'),(199,694,'SL','SLE','Sierra Leona'),(200,702,'SG','SGP','Singapur'),(201,760,'SY','SYR','Siria'),(202,706,'SO','SOM','Somalia'),(203,144,'LK','LKA','Sri Lanka'),(204,748,'SZ','SWZ','Suazilandia'),(205,710,'ZA','ZAF','Sud?frica'),(206,736,'SD','SDN','Sud?n'),(207,752,'SE','SWE','Suecia'),(208,756,'CH','CHE','Suiza'),(209,740,'SR','SUR','Surinam'),(210,744,'SJ','SJM','Svalbard y Jan Mayen'),(211,764,'TH','THA','Tailandia'),(212,158,'TW','TWN','Taiw?n'),(213,834,'TZ','TZA','Tanzania'),(214,762,'TJ','TJK','Tayikist?n'),(215,86,'IO','IOT','Territorio Brit?nico del Oc?ano ?ndico'),(216,260,'TF','ATF','Territorios Australes Franceses'),(217,626,'TL','TLS','Timor Oriental'),(218,768,'TG','TGO','Togo'),(219,772,'TK','TKL','Tokelau'),(220,776,'TO','TON','Tonga'),(221,780,'TT','TTO','Trinidad y Tobago'),(222,788,'TN','TUN','T?nez'),(223,796,'TC','TCA','Islas Turcas y Caicos'),(224,795,'TM','TKM','Turkmenist?n'),(225,792,'TR','TUR','Turqu?a'),(226,798,'TV','TUV','Tuvalu'),(227,804,'UA','UKR','Ucrania'),(228,800,'UG','UGA','Uganda'),(229,858,'UY','URY','Uruguay'),(230,860,'UZ','UZB','Uzbekist?n'),(231,548,'VU','VUT','Vanuatu'),(232,862,'VE','VEN','Venezuela'),(233,704,'VN','VNM','Vietnam'),(234,92,'VG','VGB','Islas V?rgenes Brit?nicas'),(235,850,'VI','VIR','Islas V?rgenes de los Estados Unidos'),(236,876,'WF','WLF','Wallis y Futuna'),(237,887,'YE','YEM','Yemen'),(238,262,'DJ','DJI','Yibuti'),(239,894,'ZM','ZMB','Zambia'),(240,716,'ZW','ZWE','Zimbabue');

/*Table structure for table `personal` */

DROP TABLE IF EXISTS `personal`;

CREATE TABLE `personal` (
  `idPersonal` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` char(12) DEFAULT NULL,
  `nivelacademico` varchar(30) DEFAULT NULL,
  `idProfesion` int(4) unsigned DEFAULT '0',
  `idEspecialidad` int(4) unsigned DEFAULT '0',
  `idSubEspecialidad` int(4) unsigned DEFAULT '0',
  `tipo` tinyint(1) DEFAULT NULL,
  `expanos` char(10) DEFAULT NULL,
  `expmeses` char(10) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `numerodocumento` char(15) DEFAULT NULL,
  `idEmpresa` int(7) DEFAULT NULL,
  PRIMARY KEY (`idPersonal`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `personal` */

insert  into `personal`(`idPersonal`,`nombre`,`apellido`,`cargo`,`email`,`telefono`,`nivelacademico`,`idProfesion`,`idEspecialidad`,`idSubEspecialidad`,`tipo`,`expanos`,`expmeses`,`fechaRegistro`,`estado`,`numerodocumento`,`idEmpresa`) values (2,'personal','apellido','Gerente Proyectos','nuevo@nuevo.com','63443453','Maestria',0,0,0,1,'8','7','2013-04-29 23:44:21',1,'78676644',42),(4,'aaa','aaa','aaaaaa','aaanuevo@nuevo.com','2222222222','Bachiller',0,0,0,1,'3','3','2013-05-19 01:19:07',1,'45161877',44),(5,'James','Otiniano','Desarrollo','james.otiniano@gmail.com','969782999','Doctorado',2,3,6,2,'2','3','2013-05-27 23:15:24',1,'21212121',43),(6,'khdfskjhdk','KJHDSKJHFKJSDH','JKHFDSKJFHSDKJH','nuevo@nuevo.com','2132213','Doctorado',33,3,5,1,'2','3','2013-05-30 19:34:31',1,'68676734',1),(7,'IUDHSGAUHIUFDSI','IUGFDSGFIUSDG','kjfdhskjfh','steve_seven_7@hotmail.com','fdsfsdfs','Doctorado',2,4,8,1,'3','1','2013-05-30 19:36:10',1,'6767676767',1),(8,'steve','villano','Ing. d sistemas','jsteve.villano@gmail.com','987255127','Doctorado',1,1,1,1,'3','2','2013-06-04 19:28:45',1,'46298384',1),(10,'prueba2','PRUEBAQ APELLIDO','prueba jefe 2','prueba2@gmail.com','333333333','Maestria',1,1,2,1,'2','6','2013-06-26 00:20:41',1,'78987876',1);

/*Table structure for table `pmsj_convoca` */

DROP TABLE IF EXISTS `pmsj_convoca`;

CREATE TABLE `pmsj_convoca` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL DEFAULT '',
  `compo` varchar(200) DEFAULT NULL,
  `proceso` varchar(250) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `limite` date NOT NULL DEFAULT '0000-00-00',
  `hora_lim` time DEFAULT NULL,
  `texto` text,
  `atdr` varchar(60) DEFAULT NULL,
  `atdr2` varchar(60) DEFAULT NULL,
  `atdr3` varchar(60) DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=263 DEFAULT CHARSET=latin1;

/*Data for the table `pmsj_convoca` */

insert  into `pmsj_convoca`(`ID`,`codigo`,`compo`,`proceso`,`fecha`,`limite`,`hora_lim`,`texto`,`atdr`,`atdr2`,`atdr3`,`estado`,`aresp`,`aresul`,`aabsol`,`ainfo`,`tipo`,`codpaac`,`idpoa`,`idprimera`) values (1,'CF-10',NULL,'Contratación de una firma consultora para la implementación de una línea de producción de microformas en la UC','2014-05-15','2011-05-25',NULL,NULL,'files/LPM_UCP.pdf',NULL,NULL,1,NULL,NULL,NULL,NULL,2,'CF-10',NULL,1),(2,'ca-01',NULL,'comvocatoria de personal administrativo solo nesñoritas','2013-05-10','2013-06-06',NULL,'	nuevo nuevo \r\n	\r\n','files/LPM_UCP.pdf',NULL,NULL,1,NULL,NULL,NULL,NULL,2,'co-01',NULL,1),(3,'gt-01',NULL,'proceso de compras vehiculos','2013-05-01','2013-06-01',NULL,'sadasffdsfds','files/das.pdf',NULL,NULL,1,NULL,NULL,NULL,NULL,2,'cd-ka',NULL,1),(260,'LPN-04-2012b',NULL,'ADQUISICIÓN E INSTALACIÓN DE SISTEMA DE AIRE ACONDICIONADO PARA EL LABORATORIO FORENSE AMBIENTAL DEL INSTITUTO DE MEDICINA LEGAL DEL MINISTERIO PÚBLICO','2013-05-12','2013-06-11','16:00:00',NULL,'files/LIC_adq_aire_acondicionado.pdf',NULL,NULL,1,NULL,NULL,NULL,NULL,2,'LPN-04-2012b',NULL,2),(262,'CF-36-2013',NULL,'CONTRATACIÓN DE UNA FIRMA CONSULTORA PARA DESARROLLAR E IMPLANTAR UNA SOLUCIÓN INFORMÁTICA PARA DAR SOPORTE AL EXPEDIENTE DIGITAL EMPEZANDO POR LA ESPECIALIDAD LABORAL EN UN DISTRITO JUDICIAL','2013-05-26','2013-06-10','12:00:00',NULL,'files/InstructivoCF36b.pdf',NULL,NULL,1,NULL,NULL,NULL,NULL,2,'CF-36-2013',NULL,1),(261,'LPI-01-2013',NULL,'ADQUISICIÓN DE HARDWARE Y SOFTWARE PARA INSTITUCIONES DEL SECTOR JUSTICIA','2013-05-23','2013-09-04','16:00:00',NULL,'files/Lic_01-2013ADQHADWARESOFTWARE.pdf','files/Formularioestructuradecostos36.pdf',NULL,1,NULL,NULL,NULL,NULL,2,'LPI-01-2013',NULL,1);

/*Table structure for table `profesion` */

DROP TABLE IF EXISTS `profesion`;

CREATE TABLE `profesion` (
  `idProfesion` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` char(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idProfesion`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

/*Data for the table `profesion` */

insert  into `profesion`(`idProfesion`,`descripcion`) values (1,'Abogado'),(2,'Administrador de empresas'),(3,'Administrador de Negocios Agropecuarios'),(4,'Administrador de Seguros'),(5,'Administrador en Turismo y Hotelería'),(6,'Administrador de Negocios Internacionales'),(7,'Antropólogo'),(8,'Arquitecto'),(9,'Asistente Social'),(10,'Bibliotecario'),(11,'Biólogo'),(12,'Bioquímico'),(13,'Catedrático Lengua y Literatura'),(14,'Contador'),(15,'Licenciado en Ciencias de la Comunicación'),(16,'Decoradora'),(17,'Diseñador Gráfico'),(18,'Diseñador Publicitario'),(19,'Docente'),(20,'Economista'),(21,'Estadístico'),(22,'Estudiante'),(23,'Fotógrafo'),(24,'Geólogo'),(25,'Historiador'),(26,'Licenciado en Idiomas'),(27,'Ing. Industrial'),(28,'Ing. Aeronáutico'),(29,'Ing. Agroindustrial'),(30,'Ing. Agrónomo'),(31,'Ing. Agrónomo Zootecnista'),(32,'Ing. Civil'),(33,'Ing. de Sistemas'),(34,'Ing. Electrónico'),(35,'Ing. Forestal'),(36,'Ing. Hidrólogo'),(37,'Ing. Mecánico'),(38,'Ing. Metalúrgico'),(39,'Ing. de Minas'),(40,'Ing. Naval'),(41,'Ing. Pesquero'),(42,'Ing. Quimico'),(43,'Ing. Textil'),(44,'Ing. Zootecnista'),(45,'Licenciado en Marketing'),(46,'Médico general'),(47,'Medico'),(48,'Veterinario'),(49,'Militar'),(50,'Militar (r)'),(51,'Nutricionista'),(52,'Periodista'),(53,'Psicólogo'),(54,'Psicólogo Clínico'),(55,'Publicista'),(56,'Químico Farmaceútico'),(57,'Lic. en Relaciones Industriales'),(58,'Lic. en Relaciones Internacionales'),(59,'Lic. en Relaciones Públicas'),(60,'Secretaria'),(61,'Secretaria Ejecutiva'),(62,'Secretaria Ejecutiva Bilingue'),(63,'Sociólogo'),(64,'Traductor'),(65,'Veterinario'),(66,'Zootecnista');

/*Table structure for table `referencia` */

DROP TABLE IF EXISTS `referencia`;

CREATE TABLE `referencia` (
  `idReferencia` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) unsigned NOT NULL,
  `nombre` char(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido` char(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` char(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `cargo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` char(1) DEFAULT '1',
  `fechaRegistro` datetime DEFAULT NULL,
  PRIMARY KEY (`idReferencia`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `referencia` */

insert  into `referencia`(`idReferencia`,`idEmpresa`,`nombre`,`apellido`,`email`,`telefono`,`cargo`,`estado`,`fechaRegistro`) values (1,43,'ref1','ref1','james.1otiniano@gmail.com','9697819491','lala1','1','2013-05-27 23:01:03');

/*Table structure for table `servicio` */

DROP TABLE IF EXISTS `servicio`;

CREATE TABLE `servicio` (
  `idservicio` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `nombreServicio` varchar(50) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  PRIMARY KEY (`idservicio`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='																				\n\n';

/*Data for the table `servicio` */

insert  into `servicio`(`idservicio`,`nombreServicio`,`estado`) values (1,'servicio 1','1'),(2,'servicio 2 editado','1'),(4,'servicio 3','1'),(5,'servicio 4','1'),(6,'servicio 5','1'),(7,'servicio 6','1'),(8,'servicio 7','1'),(9,'servicio 8','1'),(10,'servicio 9','1'),(11,'servicio 10','0'),(12,'servicio 11','1');

/*Table structure for table `subespecialidad` */

DROP TABLE IF EXISTS `subespecialidad`;

CREATE TABLE `subespecialidad` (
  `idSubEspecialidad` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `idEspecialidad` int(4) unsigned NOT NULL,
  `descripcion` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idSubEspecialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `subespecialidad` */

insert  into `subespecialidad`(`idSubEspecialidad`,`idEspecialidad`,`descripcion`) values (1,1,'Junior 1'),(2,1,'Semi Senior 1'),(3,2,'Junior 2'),(4,2,'Semi Senior 2'),(5,3,'Junior 3'),(6,3,'Semi Senior 3'),(7,4,'Junior 4'),(8,4,'Semi Senior 4');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
