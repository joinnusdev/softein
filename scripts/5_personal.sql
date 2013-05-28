ALTER TABLE `personal` 
   ADD COLUMN `idProfesion` INT(4) UNSIGNED DEFAULT '0' NULL AFTER `nivelacademico`, 
   ADD COLUMN `idEspecialidad` INT(4) UNSIGNED DEFAULT '0' NULL AFTER `idProfesion`, 
   ADD COLUMN `idSubEspecialidad` INT(4) UNSIGNED DEFAULT '0' NULL AFTER `idEspecialidad`;