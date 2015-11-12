CREATE TABLE IF NOT EXISTS `revista_edicoes` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`titulo` VARCHAR(80) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`banner` TEXT NULL COLLATE 'utf8_unicode_ci',
	`descricao` TEXT NULL COLLATE 'utf8_unicode_ci',
	`links` TEXT NULL COLLATE 'utf8_unicode_ci',
	`status` TINYINT(4) NOT NULL DEFAULT '0',
	`created` DATETIME NOT NULL,
	`modified` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `revista_artigos` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`titulo` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`resumo` TEXT NULL COLLATE 'utf8_unicode_ci',
	`autores` VARCHAR(120) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`edicoes_id` INT(11) NOT NULL,
	`arquivo` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`weight` INT(11) NOT NULL DEFAULT '0',
	`status` TINYINT(4) NOT NULL DEFAULT '0',
	`created` DATETIME NULL DEFAULT NULL,
	`modified` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=MyISAM;

