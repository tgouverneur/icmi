<?php
 /**
  * Ajax joblogRemove
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package ajax
  * @subpackage jobs
  * @category others
  * @filesource
  */

  if (!isset($_POST["id"])) {
    die("tss tss...");
  }
  require_once(dirname(__FILE__)."/../../inc/config.inc.php");
  require_once(dirname(__FILE__)."/../../libs/autoload.lib.php");

  /* fetching devices */
  $h = HTTP::getInstance();
  $m = mysqlCM::getInstance();
  if ($m->connect()) {
    die($argv[0]." Error with SQL db: ".$m->getError()."\n");
  }
  $j = new JobLog($_POST["id"]);
  $j->fetchFromId();

  $j->delete();
?>
