<?php

 function updateXML($hostname, $domain) {
   global $argv;

   echo "[-] Connecting to MySQL...";
   $m = mysqlCM::getInstance();
   if ($m->connect()) {
     die($argv[0]." Error with SQL db: ".$m->getError()."\n");
   }
   echo " [ok]\n";
   echo "[-] Fetching device information from DB...";
   $device = new Device();
   $device->hostname = $hostname;
   $device->domain = $domain;
   if ($device->fetchFromFields(array("hostname", "domain")) == -1) {
     echo " [nok]\n";
     echo $argv[0]." Can't find specified device in database.\n";
     exit(1);
   }
   $device->o_version = new Version($device->idversion);
   if ($device->o_version->fetchFromId() == -1) {
     echo " [nok]\n";
     echo $argv[0]." Can't fetch version information from database.\n";
     exit(1);
   }
   $device->o_version->o_scheme = new Scheme($device->o_version->scheme_id);
   if ($device->o_version->o_scheme->fetchFromId() == -1) {
     echo " [nok]\n";
     echo $argv[0]." Can't fetch scheme information from database.\n";
     exit(1);
   }
   $device->o_buser = new User($device->idbuser, "B");
   if ($device->o_buser->fetchFromId() == -1) {
     echo " [nok]\n";
     echo $argv[0]." Can't fetch backup user information from database.\n";
     exit(1);
   }
   echo " [ok]\n";
   echo "[-] Fetching XML into Array...";
   if ($device->loadFromXML() == -1) {
     echo " [nok]\n";
     exit(2);
   } else {
     echo " [ok]\n";
   }
   echo "[-] Saving config to DB...";
   if ($device->toDB() == -1) {
     echo " [nok]\n";
     exit(2);
   } else {
     echo " [ok]\n";
   }

   $m->disconnect();
   return;  
 }

 function listItem($what) {
   global $argv;

   switch($what) {
     /****
      ** LIST DEVICES **
      ****/
     case "device":
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
       printf("%20s\t%30s\t%20s\t%10s\n", "hostname", "domain", "type", "version");
       foreach ($dlist as $d) {
         printf("%20s\t%30s\t%20s\t%10s\n", $d->hostname, $d->domain, 
                                            $d->o_version->flavour, 
                                            $d->o_version->version);
       }
       $m->disconnect();
       return;
     break;
     /****
      ** LIST SUPPORTED VERSION **
      ****/
     case "version":
       $vlist = array();
       $index = "`version_id`";
       $table = "version";
       $where = "";
       $m = mysqlCM::getInstance();
       if ($m->connect()) {
         die($argv[0]." Error with SQL db: ".$m->getError()."\n");
       }
       if (($idx = $m->fetchIndex($index, $table, $where)))
       {
         foreach($idx as $t) {
           $v = new Version($t["version_id"]);
           $v->fetchFromId();
           array_push($vlist, $v);
         }
       }
       printf("%20s\t%7s\t%11s\t%s\n", "flavour", "version", "cfg_version", "description"); 
       foreach ($vlist as $v) {
         printf("%20s\t%7s\t%11s\t%s\n", $v->flavour, $v->version, $v->cfg_version, $v->description);
       }
       $m->disconnect();
       return;
     break;
     default:
       echo $argv[0]." -i unknown item...\n";
     break;
   }
 }

?>
