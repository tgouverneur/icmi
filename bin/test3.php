<?php
 require_once("./inc/config.inc.php");
 require_once("./libs/autoload.lib.php");

 if ($argc != 3)
   die($argv[0]." <hostname> <domainname>\n");

 $m = mysqlCM::getInstance();
 if ($m->connect()) {
   die("Error with SQL db: ".$m->getError()."\n");
 }

 $loader = new Loader();
 $device = new Device();
 $device->hostname = $argv[1];
 $device->domain = $argv[2];
 $device->https = 0;
 $device->port = 80;
 if ($loader->loadFromUnknown($device, "admin", "popol") == -1) {
   if ($loader->dataArray == NULL &&
       $loader->dataXML != NULL) {
     echo "[!] Version unknown, unable to convert to array\n";
     echo $loader->dataXML;
   } else if ($loader->dataXML == NULL) {
     echo "[!] Unable to load XML file from device\n";
   } else {
     echo "[!] Unexpected error. Shit happen.\n";
   }
 } else {
   echo "[-] Device type: ".$device->o_version->flavour."\n";
   echo "[-] Version detected: ".$device->o_version->version."\n";
   echo "[-] Device configuration loaded succesfully\n";
 }

?>
