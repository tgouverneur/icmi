--
-- Supported versions
--
DROP TABLE IF EXISTS `version`;
CREATE TABLE `version` (
  `version_id` int(11) NOT NULL auto_increment,
  `flavour` varchar(255) NOT NULL,
  `version` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  `scheme_id` int(11) NOT NULL,
  PRIMARY KEY  (`version_id`)
);

--
-- Schemas for differents configurations
--
-- RMQ: tree is a serialized PHP object listing
--      different object and where to find them.
--
DROP TABLE IF EXISTS `scheme`;
CREATE TABLE `scheme` (
  `scheme_id` int(11) NOT NULL auto_increment,
  `rootobj` varchar(50) NOT NULL,
  `tags` text NOT NULL,
  `tree` text NOT NULL,
  PRIMARY KEY  (`scheme_id`)
);

--
-- Devices
--
DROP TABLE IF EXISTS `device`;
CREATE TABLE `device` (
  `device_id` int(11) NOT NULL auto_increment,
  `hostname` varchar(50) NOT NULL,
  `domain` varchar(90) NOT NULL,
  `address` varchar(16) NOT NULL,
  `changed` varchar(50) NOT NULL,
  `updated` varchar(50) NOT NULL,
  `port` int(5) NOT NULL default '80',
  `https_f` int(1) NOT NULL default '0',
  `useip_f` int(1) NOT NULL default '0',
  `enable_f` int(1) NOT NULL default '1',
  `autobackup_f` int(1) NOT NULL default '0',
  `version_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `buser_id` int(11) NOT NULL,
  `auser_id` int(11) NOT NULL,
  PRIMARY KEY  (`device_id`)
);

--
-- Group of devices
--
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `group_id` int(11) NOT NULL auto_increment,
  `name` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`group_id`)
);

--
-- "Various" properties table
--
DROP TABLE IF EXISTS `property`;
CREATE TABLE `property` (
  `property_id` int(11) NOT NULL auto_increment,
  `name`	varchar(50) NOT NULL,
  `type`	varchar(1) NOT NULL default 'T',
  `value`	varchar(255) NOT NULL,
  `parent_id`	int(11) NOT NULL,
  `device_id`	int(11) NOT NULL,
  PRIMARY KEY  (`property_id`)
);

--
-- Datas
--
DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
  `data_id` int(11) NOT NULL auto_increment,
  `name`	varchar(255) NOT NULL,
  `type`	varchar(1) NOT NULL default 'T',
  `value`	text NOT NULL,
  `foreign_table` varchar(50) NOT NULL,
  `foreign_id`	int(11) NOT NULL,
  PRIMARY KEY  (`data_id`)
);

--
-- Users
--
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `type` varchar(1) NOT NULL default 'A',
  `device_id` int(11) NOT NULL,
  `ugroup_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`)
);

--
-- Group of users
--
DROP TABLE IF EXISTS `ugroup`;
CREATE TABLE `ugroup` (
  `ugroup_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `pages` text NOT NULL,
  PRIMARY KEY  (`ugroup_id`)
);

--
-- Aliases
--
DROP TABLE IF EXISTS `alias`;
CREATE TABLE `alias` (
  `alias_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `address` varchar(16) NOT NULL,
  `global_f` int(1) NOT NULL default '0',
  `device_id` int(11) NOT NULL,
  PRIMARY KEY  (`alias_id`)
);

