
CREATE TABLE IF NOT EXISTS `gallery_galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text,
  `params` text,
  `status` int(11) DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251;

CREATE TABLE IF NOT EXISTS `gallery_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `params` text,
  `status` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_photos_albums` (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251;
