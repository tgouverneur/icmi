--
-- Table structure for table `alias`
--

DROP TABLE IF EXISTS `alias`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `alias` (
  `alias_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `address` varchar(16) NOT NULL,
  `global_f` int(1) NOT NULL default '0',
  `device_id` int(11) NOT NULL,
  PRIMARY KEY  (`alias_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `data` (
  `data_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `type` varchar(1) NOT NULL default 'T',
  `value` text NOT NULL,
  `foreign_table` varchar(50) NOT NULL,
  `foreign_id` int(11) NOT NULL,
  PRIMARY KEY  (`data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `group` (
  `group_id` int(11) NOT NULL auto_increment,
  `name` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `property` (
  `property_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `type` varchar(1) NOT NULL default 'T',
  `value` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  PRIMARY KEY  (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `scheme`
--

DROP TABLE IF EXISTS `scheme`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `scheme` (
  `scheme_id` int(11) NOT NULL auto_increment,
  `rootobj` varchar(50) NOT NULL,
  `tags` text NOT NULL,
  `tree` text NOT NULL,
  PRIMARY KEY  (`scheme_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `scheme`
--

LOCK TABLES `scheme` WRITE;
/*!40000 ALTER TABLE `scheme` DISABLE KEYS */;
INSERT INTO `scheme` VALUES (1,'m0n0wall','rule user group key dnsserver winsserver pages encryption-algorithm-option hash-algorithm-option hosts tunnel onetoone staticmap route alias pipe queue shellcmd cacert earlyshellcmd mobilekey servernat proxyarpnet passthrumac allowedip wolentry vlan domainoverrides element',''),(2,'pfsense','rule user group key dnsserver winsserver pages encryption-algorithm-option hash-algorithm-option hosts tunnel onetoone staticmap route alias pipe queue shellcmd cacert earlyshellcmd mobilekey servernat proxyarpnet passthrumac allowedip wolentry vlan domainoverrides element alias aliasurl allowedip authserver bridged ca cacert cert config columnitem depends_on_package disk dnsserver dnsupdate domainoverrides dyndns earlyshellcmd element encryption-algorithm-option field fieldname hash-algorithm-option gateway_item gateway_group gif gre group hosts member interface_array item key lagg lbaction lbpool lbprotocol member menu tab mobilekey monitor_type mount ntpserver onetoone openvpn-server openvpn-client openvpn-csc option ppp package passthrumac phase1 phase2 priv proxyarpnet queue pages pipe route row rule schedule service servernat servers serversdisabled earlyshellcmd shellcmd staticmap subqueue timerange tunnel user vip virtual_server vlan winsserver wolentry widget',''),(3,'m0n0wall','rule rule6 user group key dnsserver winsserver pages encryption-algorithm-option hash-algorithm-option hosts tunnel onetoone staticmap route route6 alias pipe queue shellcmd cacert earlyshellcmd mobilekey servernat proxyarpnet passthrumac allowedip wolentry vlan domainoverrides element roll active','');
/*!40000 ALTER TABLE `scheme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ugroup`
--

DROP TABLE IF EXISTS `ugroup`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ugroup` (
  `ugroup_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `pages` text NOT NULL,
  PRIMARY KEY  (`ugroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `type` varchar(1) NOT NULL default 'A',
  `device_id` int(11) NOT NULL,
  `ugroup_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `version`
--

DROP TABLE IF EXISTS `version`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `version` (
  `version_id` int(11) NOT NULL auto_increment,
  `flavour` varchar(255) NOT NULL,
  `version` varchar(25) NOT NULL,
  `cfg_version` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `scheme_id` int(11) NOT NULL,
  PRIMARY KEY  (`version_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `version`
--

LOCK TABLES `version` WRITE;
/*!40000 ALTER TABLE `version` DISABLE KEYS */;
INSERT INTO `version` VALUES (1,'m0n0wall','1.235','1.6','m0n0wall version 1.235',1),(2,'pfsense','1.2.2','3.0','pfsense device',2),(3,'m0n0wall','1.3b15','1.8','m0n0wall version 1.3b15',3);
/*!40000 ALTER TABLE `version` ENABLE KEYS */;
UNLOCK TABLES;
