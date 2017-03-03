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

  $content = new Template("./tpl/help.tpl");

  $js = array("ax_main.js");
  $css = array("cs_main.css");
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
