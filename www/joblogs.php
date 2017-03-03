<?php
 /**
  * Index page
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package web
  * @subpackage main
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

  $content = new Template("./tpl/joblogs.tpl");

  /* fetching devices */
  $jlist = array();
  $index = "`id`";
  $table = "joblogs";
  $where = "ORDER BY `started_time` DESC";
  $m = mysqlCM::getInstance();
  if ($m->connect()) {
    die($argv[0]." Error with SQL db: ".$m->getError()."\n");
  }
  if (($idx = $m->fetchIndex($index, $table, $where)))
  {
    foreach($idx as $t) {
      $j = new JobLog($t["id"]);
      $j->fetchFromId();
      array_push($jlist, $j);
    }
  }


  $data["joblogs"] = $jlist;

  $js = array("ax_main.js", "ax_joblogs.js");
  $css = array("cs_main.css", "cs_joblogs.css");
  $data["js"] = $js; 
  $data["css"] = $css; 

  $head->set("data", $data);
  $content->set("data", $data);

  $page->set("head", $head);
  $page->set("menu", $menu);
  $page->set("foot", $foot);
  $page->set("content", $content);
  echo $page->fetch();
?>
