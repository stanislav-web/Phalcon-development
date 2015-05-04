CREATE TABLE `item_attributes` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `integer` tinyint(1) unsigned NOT NULL default 0,
  `decimal` tinyint(1) unsigned NOT NULL default 0,
  `varchar` tinyint(1) unsigned NOT NULL default 0,
  `date` tinyint(1) unsigned NOT NULL default 0,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_integer` (`integer`),
  KEY `idx_decimal` (`decimal`),
  KEY `idx_varchar` (`varchar`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;