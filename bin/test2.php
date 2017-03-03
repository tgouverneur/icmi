<?php
 require_once("./inc/config.inc.php");
 require_once("./libs/autoload.lib.php");


 $curl = new Curl();
 $url = "http://";
 $url .= "pfs01.wav.espix.org";
 $url .= "/diag_backup.php";
 $curl->setUsername("admin");
 $curl->setPassword("popol");
 $postData ="Submit=Download configuration";
 $ret = $curl->get($url,$postData); 
echo $ret;

 $listtags = "rule user group key dnsserver winsserver pages " .
             "encryption-algorithm-option hash-algorithm-option hosts tunnel onetoone " .
             "staticmap route alias pipe queue shellcmd cacert earlyshellcmd mobilekey " .
             "servernat proxyarpnet passthrumac allowedip wolentry vlan domainoverrides element";

 $xmlparser = new xmlParser($listtags);
 if (!$xmlparser->parse_xml_config($ret, "m0n0wall")) {
   var_dump($xmlparser->getCfg());
 } else {
   echo "Error while parsing\n";
   echo $xmlparser->current;
   echo $ret;
 }

?>
