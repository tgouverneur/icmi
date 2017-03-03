<?php
 /**
  * Device list
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package web
  * @subpackage device
  * @category WWW
  * @filesource
  */

  require_once(dirname(__FILE__)."/../inc/config.inc.php");
  require_once(dirname(__FILE__)."/../libs/autoload.lib.php");

  require_once("./libs/template.obj.php");

  $page = new Template("./tpl/index.tpl");
  $head = new Template("./tpl/head.tpl");
  $foot = new Template("./tpl/foot.tpl");
  $menu = new Template("./tpl/menu.tpl");


  $content = new Template("./tpl/devices.tpl");

  /* fetching devices */
  $dlist = array();
  $index = "`device_id`";
  $table = "device";
  $where = "";
  $m = mysqlCM::getInstance();
  if ($m->connect()) {
    die($argv[0]." Error with SQL db: ".$m->getError()."\n");
  }
  if (($idx = $m->fetchIndex($index, $table, $where)))
  {
    foreach($idx as $t) {
      $d = new Device($t["device_id"]);
      $d->fetchFromId();
      $d->o_version = new Version($d->idversion);
      $d->o_version->fetchFromId();
      array_push($dlist, $d);
    }
  }

  
  $js = array("ax_main.js", "ax_devices.js");
  $css = array("cs_main.css", "cs_devices.css");
  $data["devices"] = $dlist;
  $data["js"] = $js; 
  $data["css"] = $css; 

  $content->set("data", $data);
  $head->set("data", $data);

  $page->set("head", $head);
  $page->set("menu", $menu);
  $page->set("foot", $foot);
  $page->set("content", $content);
  echo $page->fetch();
?>
