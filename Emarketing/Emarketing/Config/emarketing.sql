CREATE TABLE IF NOT EXISTS `emarketing_mailings` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NULL DEFAULT NULL,
	`from` VARCHAR(50) NULL DEFAULT NULL,
	`created` DATETIME NULL DEFAULT NULL,
	`modified` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `croogo`.`emarketing_sents`(  
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `mailing_id` INT(10),
  `nome` VARCHAR(100),
  `email` VARCHAR(100),
  `created` DATETIME,
  `modified` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `emarketing_contacts` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(50) NULL DEFAULT NULL,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`status` TINYINT NOT NULL DEFAULT '1',
	`created` DATETIME NOT NULL,
	`modified` DATETIME NOT NULL,
	UNIQUE INDEX `email` (`email`),
	PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `emarketing_outboxes` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`mailing_id` INT(11) NULL DEFAULT NULL,
	`nome` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`to` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`subject` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`body` TEXT NULL COLLATE 'utf8_unicode_ci',
	`status` TINYINT(1) UNSIGNED NULL DEFAULT '0',
	`created` DATETIME NULL DEFAULT NULL,
	`modified` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=MyISAM;


