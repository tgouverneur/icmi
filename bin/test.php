<?php
 require_once("./inc/config.inc.php");
 require_once("./libs/autoload.lib.php");

 $m = mysqlCM::getInstance();
 if ($m->connect()) {
   die("Error with SQL db: ".$m->getError()."\n");
 }
 echo "[*] Connected to SQL db\n";

 $dev = new Device();
 $dev->hostname = "test";
 $dev->domain = "prout.com";

 if ($dev->existsDB()) {
   echo "[-] object exists in db..\n";
 }
 if (($rc = $dev->fetchFromField("hostname"))) {
   echo "[x] Error fetching from db ($rc)\n";
   $dev->id = -1;
   $dev->hostname = "test";
   $dev->domain = "wav.espix.org";
   if (($rc = $dev->insert())) {
     echo "[x] Error inserting..\n";
   } else {
     echo "[-] Row inserted..(".$dev->id.")\n";
     $dev->domain = "prout.com";
     if (($rc = $dev->update())) {
       echo "[x] Error updating ($rc)\n";
     } else {
       echo "[-] Updated (".mysqlCM::getInstance()->getAffect()."): ".$dev->hostname.".".$dev->domain."\n";
     }
   }
 } else {
   echo "[-] Fetched: ".$dev->hostname.".".$dev->domain."\n";

   $dev->delete();
   echo "[-] Removed from db...\n";
 }

 if ($m->disconnect()) {
   die("Error with SQL db: ".$m->getError()."\n");
 }
 echo "[*] Disconnected from SQL db\n";
?>
