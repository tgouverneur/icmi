<?php
 /**
  * Device object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */

class Device extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $hostname = "";	/* hostname (sqdn) */
  public $domain = "";		/* domain name */
  public $use_ip = 0;		/* should we use ipaddr to connect ? */
  public $https = 1;		/* https = 1 | http = 0 */
  public $address = "";		/* ipaddress of this device */
  public $port = 443;		/* port of http interface */
  public $idbuser = -1;		/* link to the backup user */
  public $idauser = -1;		/* link to the admin user */
  public $idversion = -1;	/* link to the version */
  public $idgroup = -1;		/* link to the group */
  public $changed = 0;		/* when does the config has changed ? */
  public $updated = 0;		/* when was the last update ? */
  public $autobackup = 1;	/* auto backup */
  public $enabled = 1;		/* enabled ? */
  public $online = 0;		/* online ? */

  public $o_buser, $o_version, $o_group, $o_auser;

  public $loader = NULL;

 /**
  * Save config into database
  */
  public function toDB()
  {
     if (!$this->loader->dataArray)
       return -1;

     if ($this->loader->toDB($this) == -1)
       return -1;

     return 0;
  }

 /**
  * Load from XML
  */
  public function loadFromXML()
  {
    $this->loader = new Loader();

    if ($this->idversion != -1 &&
        $this->o_version == NULL) {
      $this->o_version = new Version($this->idversion);
      if ($this->o_version->fetchFromId() == -1) {
        return -1;
      }
    }

    if ($this->idbuser != -1 &&
        $this->o_buser == NULL) {
      $this->o_buser = new User($this->idbuser, "A");
      if ($this->o_buser->fetchFromId() == -1) {
        return -1;
      } 
    }
  
    if ($this->idbuser == -1 &&
        $this->o_buser == NULL) {
 
      return -1;
    }

    if ($this->idversion == -1 &&
        $this->o_version == NULL) {
      if ($this->loader->loadFromUnknown($this, 
	  $this->o_buser->username, 
	  $this->o_buser->password) == -1) {

        return -1;
      }
      return 0;
    } else {
      if ($this->loader->loadFromKnown($this) == -1) {
        return -1;
      }
      return 0;
    }
    return -1; /* impossible case */
  }

 /**
  * ctor
  */
  public function __construct($id=-1) 
  { 
    $this->id = $id;
    $this->_table = "device";
    $this->_my = array( 
			"device_id" => SQL_INDEX, 
		        "hostname" => SQL_PROPE|SQL_EXIST|SQL_WHERE, 
		        "domain" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"enable_f" => SQL_PROPE,
			"useip_f" => SQL_PROPE,
			"https_f" => SQL_PROPE,
			"autobackup_f" => SQL_PROPE,
			"address" => SQL_PROPE,
			"buser_id" => SQL_PROPE,
			"auser_id" => SQL_PROPE,
			"group_id" => SQL_PROPE,
			"version_id" => SQL_PROPE,
			"online" => SQL_PROPE,
			"updated" => SQL_PROPE,
			"changed" => SQL_PROPE,
			"port" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"device_id" => "id", 
		        "hostname" => "hostname", 
		        "domain" => "domain",
			"enable_f" => "enabled",
			"useip_f" => "use_ip",
			"address" => "address",
			"buser_id" => "idbuser",
			"auser_id" => "idauser",
			"group_id" => "idgroup",
			"updated" => "updated",
			"changed" => "changed",
			"online" => "online",
			"port" => "port",
			"https_f" => "https",
			"version_id" => "idversion",
			"autobackup_f" => "autobackup"
 		 );
  }
}

?>
