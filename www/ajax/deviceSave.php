<?php
 /**
  * Ajax deviceSave
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


  $h = HTTP::getInstance();
 
  $m = mysqlCM::getInstance();
  if ($m->connect()) {
    die($argv[0]." Error with SQL db: ".$m->getError()."\n");
  }
  if (($tmp = $h->getHTTPVar("id")) == null && !empty($tmp)) {
    echo "-1";
    exit(-1);
  }
  $d = new Device($tmp);
  if ($d->fetchFromId() == -1) {
    echo "-1";
    exit(-1);
  }
  $c = 0;

  if (($tmp = $h->getHTTPVar("hostname")) == null && !empty($tmp)) {
    echo "-1";
    exit(-1);
  }
  if (strcmp($d->hostname, $tmp)) {
    $d->hostname = $tmp;
    $c = 1;
  }

  if (($tmp = $h->getHTTPVar("domain")) == null && !empty($tmp)) {
    echo "-1";
    exit(-1);
  }
  if (strcmp($d->domain, $tmp)) {
    $d->domain = $tmp;
    $c = 1;
  }

  $tmp = $h->getHTTPVar("ip");
  if (strcmp($d->address, $tmp)) {
    $d->address = $tmp;
    $c = 1;
  }

  $tmp = $h->getHTTPVar("port");
  if (strcmp($d->port, $tmp)) {
    $d->port = $tmp;
    $c = 1;
  }

  if (($tmp = $h->getHTTPVar("useip")) == null) {
    echo "-1";
    exit(-1);
  }
  if (strcmp($d->use_ip, $tmp)) {
    $d->use_ip = $tmp;
    $c = 1;
  }

  if (($tmp = $h->getHTTPVar("https")) == null) {
    echo "-1";
    exit(-1);
  }
  if (strcmp($d->https, $tmp)) {
    $d->https = $tmp;
    $c = 1;
  }

  if (($tmp = $h->getHTTPVar("enabled")) == null) {
    echo "-1";
    exit(-1);
  }
  if (strcmp($d->enabled, $tmp)) {
    $d->enabled  = $tmp;
    $c = 1;
  }

  if (($tmp = $h->getHTTPVar("autobackup")) == null) {
    echo "-1";
    exit(-1);
  }
  if (strcmp($d->autobackup, $tmp)) {
    $d->autobackup = $tmp;
    $c = 1;
  }

  if (empty($d->port)) {
    if ($d->https && $d->port != 443) {
      $d->port = 443;
      $c = 1;
    } else if (!$d->https && $d->port != 80){
      $d->port = 80;
      $c = 1;
    }
  }

  /* save the device if needed */
  if ($c) {
    $d->changed = date("U");
    if ($d->update() == -1) {
      echo "-1";
    } else {
      echo "1";
    }
  } else {
    echo "0";
  }
//  header ("Content-Type: text/xml");
?>
