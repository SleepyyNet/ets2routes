DROP TABLE IF EXISTS `update`;

CREATE TABLE `update` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`key` VARCHAR(50) NOT NULL,
	`value` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

INSERT INTO `update` (`id`, `key`, `value`) VALUES
	(1, 'A key', 'A val'),
	(2, 'test', 'test2');
