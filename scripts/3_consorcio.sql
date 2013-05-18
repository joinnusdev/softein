alter table `empresa` add column `consorcio` int(11) NULL after `confirmar`;

alter table `empresa` change `confirmar` `confirmar` varchar(50) character set utf8 collate utf8_general_ci NULL  comment 'Confirmacion por correo', change `consorcio` `consorcio` int(11) default '0' NULL ;