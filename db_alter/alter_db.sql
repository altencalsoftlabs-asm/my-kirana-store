DROP TABLE IF EXISTS `pack_type`;
CREATE TABLE IF NOT EXISTS `pack_type` (
  `pack_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`pack_type_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `product` CHANGE `date_available` `date_available` DATE NULL DEFAULT NULL;
ALTER TABLE `product` ADD `fld_approved` TINYINT(6) NOT NULL DEFAULT '0' AFTER `viewed`;
CREATE TABLE IF NOT EXISTS `product_custom` (
  `product_custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `pack_type_id` int(11) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`product_custom_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE `product_custom` ADD `language_id` INT(11) NOT NULL AFTER `product_id`;
CREATE TABLE IF NOT EXISTS `product_gender` (
  `product_gender_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`product_gender_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `kirana_type` (
  `kirana_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`kirana_type_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `kirana_locality` (
  `kirana_locality_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`kirana_locality_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `product_custom` ADD `product_gender_id` INT(11) NULL DEFAULT NULL AFTER `pack_type_id`;
ALTER TABLE `product_custom` ADD `kirana_type_id` INT(11) NULL DEFAULT NULL AFTER `product_gender_id`, ADD `kirana_locality_id` INT(11) NULL DEFAULT NULL AFTER `kirana_type_id`;
ALTER TABLE `product_custom` ADD `gift_item` TINYINT(6) NOT NULL DEFAULT '0' AFTER `kirana_locality_id`;
ALTER TABLE `product_custom` ADD `seasonal` TINYINT(6) NOT NULL DEFAULT '0' AFTER `product_id`;
ALTER TABLE `product_custom` ADD `seasonal_duration` VARCHAR(255) NULL DEFAULT NULL AFTER `seasonal`;
ALTER TABLE `product_custom` ADD `seasonal_start_date` VARCHAR(255) NULL DEFAULT NULL AFTER `seasonal_duration`;
ALTER TABLE `product_custom` ADD `seasonal_end_date` VARCHAR(255) NULL DEFAULT NULL AFTER `seasonal_start_date`;
ALTER TABLE `product_custom` ADD `private_item` TINYINT(6) NOT NULL DEFAULT '0' AFTER `seasonal_end_date`;
ALTER TABLE `product_custom` ADD `regional_product` TINYINT(6) NOT NULL DEFAULT '0' AFTER `gift_item`;
ALTER TABLE `product_custom` ADD `region_definition` VARCHAR(255) NULL DEFAULT NULL AFTER `regional_product`;
ALTER TABLE `product` ADD `date_available_end` VARCHAR(255) NULL DEFAULT NULL AFTER `date_available`;
CREATE TABLE IF NOT EXISTS `product_retailer` (
  `product_retailer_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_retailer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
---21-May-2017----
ALTER TABLE `product_custom` ADD `kirana_availability` TINYINT(6) NOT NULL DEFAULT '0' AFTER `product_gender_id`;
ALTER TABLE `product_custom` CHANGE `regional_product` `regional_product` VARCHAR(255) NULL DEFAULT NULL;
CREATE TABLE IF NOT EXISTS `user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
INSERT INTO `user_type` (`user_type_id`, `name`) VALUES
(1, 'Super Admin'),
(2, 'Approval Admin'),
(3, 'Data Entry Admin'),
(4, 'Normal Admin');
ALTER TABLE `user` ADD `user_type_id` INT(11) NULL DEFAULT NULL AFTER `user_group_id`;
---22-May-2018---
ALTER TABLE `product` CHANGE `fld_approved` `kirana_status` TINYINT(6) NOT NULL DEFAULT '0';
ALTER TABLE `product` ADD `no_of_approval` TINYINT(6) NOT NULL DEFAULT '0' AFTER `viewed`;
CREATE TABLE IF NOT EXISTS `product_approval_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fld_comment` varchar(255) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE `product_approval_user` ADD `fld_message` VARCHAR(255) NOT NULL AFTER `user_id`;
ALTER TABLE `product_approval_user` CHANGE `approval_user_id` `approval_id` INT(11) NOT NULL AUTO_INCREMENT;

--23-May-2018--
CREATE TABLE IF NOT EXISTS `bulkupload` (
  `bulkupload_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(160) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`bulkupload_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `bulkupload` ADD `status` TINYINT(6) NOT NULL DEFAULT '0' AFTER `filename`;
ALTER TABLE `bulkupload` CHANGE `date_added` `date_added` DATETIME NULL DEFAULT NULL;
ALTER TABLE `bulkupload` ADD `date_modified` DATETIME NOT NULL AFTER `date_added`;
ALTER TABLE `bulkupload` ADD `fld_message` VARCHAR(255) NULL DEFAULT NULL AFTER `filename`;

ALTER TABLE `product` CHANGE `gift_item` `gift_item` TINYINT(1) NULL DEFAULT '0' COMMENT 'yes/no';
ALTER TABLE `product` CHANGE `kirana_availability` `kirana_availability` TINYINT(1) NULL DEFAULT '0';
ALTER TABLE `product` CHANGE `private_item` `private_item` TINYINT(1) NULL DEFAULT '0';
ALTER TABLE `product_description` ADD COLUMN `short_description` VARCHAR(255) NULL AFTER `name`;
