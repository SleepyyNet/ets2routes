DROP TABLE IF EXISTS `table`;
DROP TABLE IF EXISTS `table_auth`;
DROP TABLE IF EXISTS `table_cat`;

CREATE TABLE IF NOT EXISTS `table` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat` int(10) unsigned NOT NULL,
  `auth` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `table_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `table_cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `table` (`id`, `cat`, `auth`, `name`) VALUES
	(1, 1, 1, 'Table name');
INSERT INTO `table_auth` (`id`, `name`) VALUES
	(1, 'Test'),
	(2, 'Test 2');
INSERT INTO `table_cat` (`id`, `name`) VALUES
	(1, 'Cat Test'),
	(2, 'Cat Second test');
