<?php
 /**
  * Ajax deviceForm
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package ajax
  * @subpackage device
  * @category others
  * @filesource
  */

  if (!isset($_POST["id"])) {
    die("tss tss...");
  }
  require_once(dirname(__FILE__)."/../../inc/config.inc.php");
  require_once(dirname(__FILE__)."/../../libs/autoload.lib.php");

  /* fetching devices */
  $dlist = array();
  $index = "`device_id`";
  $table = "device";
  $where = "";
  $h = HTTP::getInstance();
  $m = mysqlCM::getInstance();
  if ($m->connect()) {
    die($argv[0]." Error with SQL db: ".$m->getError()."\n");
  }
  $h->sanitizeArray($_POST);
  $d = new Device($_POST["id"]);
  $d->fetchFromId();
  $d->o_version = new Version($d->idversion);
  $d->o_version->fetchFromId();
  header ("Content-Type: text/xml");
?>
<?xml version="1.0" ?>
<device>
 <id value="<?php echo $d->id; ?>" />
 <hostname value="<?php echo $d->hostname; ?>" />
 <domain value="<?php echo $d->domain; ?>"/>
 <address value="<?php echo $d->address; ?>"/>
 <port value="<?php echo $d->port; ?>"/>
 <autobackup value="<?php echo $d->autobackup; ?>"/>
 <use_ip value="<?php echo $d->use_ip; ?>"/>
 <https value="<?php echo $d->https; ?>"/>
 <updated value="<?php echo $d->updated; ?>"/>
 <changed value="<?php echo $d->changed; ?>"/>
 <online  value="<?php echo $d->online; ?>"/>
 <enabled value="<?php echo $d->enabled; ?>"/>
 <online value="<?php echo $d->online; ?>"/>
 <version flavour="<?php echo $d->o_version->flavour; ?>" ver="<?php echo $d->o_version->version; ?>" cfg="<?php echo $d->o_version->cfg_version; ?>" description="<?php echo $d->o_version->description; ?>" />
</device>
