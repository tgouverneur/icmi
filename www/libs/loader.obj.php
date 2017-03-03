<?php
 /**
  * Loader object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */

class Loader
{
 public $dataArray = NULL;
 public $dataXML = NULL;

 /**
  * ctor
  */
  public function __construct() 
  { 
  }
 
  /**
   * Load config from an unknown device
   * -> Need to discover it in beforehand.
   * @return 0 if no error.
   */
  public function loadFromUnknown(&$dev, $username, $password) {

    if ($dev->idversion == -1 && !$dev->o_version) {

      $url = ($dev->https)?"https://":"http://";
      $url .= ($dev->use_ip)?$dev->address:$dev->hostname.".".$dev->domain;
      $url .= ":".$dev->port;
      $url .= "/diag_backup.php";

      $curl = new Curl(); 
      $curl->setUsername($username);
      $curl->setPassword($password);

      $postData ="Submit=Download configuration";

      $ret = $curl->get($url,$postData);
      if ($ret == FALSE) {
        return -1;
      } else {
        $this->dataXML = $ret;
        /* detect flavour */
        $lines = explode("\n", $ret);
        $tmp = explode("<", $lines[1]);
        $tmp = explode(">", $tmp[1]);
        $rootobj = $tmp[0];
        foreach ($lines as $line) {
          if (ereg("<version>.*<\/version>", $line)) {
            $tmp = explode("<version>", $line);
            $tmp = explode("</version>", $tmp[1]);
            $cfg_version = $tmp[0];
            break;
          }
        }
        $dev->o_version = new Version();
        $dev->o_version->flavour = $rootobj;
        $dev->o_version->cfg_version = $cfg_version;
	$fields = array("cfg_version","flavour");
        if ($dev->o_version->fetchFromFields($fields) == -1) {
          return -1;
        }
        if ($dev->o_version->scheme_id) {
          $dev->o_scheme = new Scheme($dev->o_version->scheme_id);
          if ($dev->o_scheme->fetchFromId() == -1) {
            return -1;
          }
          $xmlparser = new xmlParser($dev->o_scheme->tags);
          if ($xmlparser->parse_xml_config($ret, $rootobj) == -1) {
            return -1;
          }
          $this->dataArray = $xmlparser->getCfg();
          return 0;
        }
      }
    }
    return -1;
  }

  /**
   * Load config from a known device
   * @return 0 if no error.
   */
  public function loadFromKnown($dev) {

    if ($dev->idversion != -1 && $dev->o_version && $dev->o_buser) {

      $url = ($dev->https)?"https://":"http://";
      $url .= ($dev->use_ip)?$dev->address:$dev->hostname.".".$dev->domain;
      $url .= ":".$dev->port;
      $url .= "/diag_backup.php";

      $curl = new Curl(); 
      $curl->setUsername($dev->o_buser->username);
      $curl->setPassword($dev->o_buser->password);

      $postData ="Submit=Download configuration";

      $ret = $curl->get($url,$postData);
      if ($ret == FALSE) {
        return -1;
      } else {
        if ($dev->o_version->scheme_id) {
          if (!$dev->o_version->o_scheme) {
            $dev->o_scheme = new Scheme($dev->o_version->scheme_id);
            if ($dev->o_scheme->fetchFromId() == -1) {
              return -1;
            }
          }
          $xmlparser = new xmlParser($dev->o_scheme->tags);
          $xmlparser->parse_xml_config($ret, $rootobj);
          $this->dataArray = $xmlparser->getCfg();
          return 0;
        }
      }
    }
    return -1;
  }


  /**
   * Save everything into the database
   */
  public function toDB($dev)
  {
    /* check prerequisites */
    if (!$dev->o_version || !$dev->o_version->o_scheme)
      return -1;
 
    /* Take the array after the root object */
    $data = $this->dataArray[$dev->o_version->o_scheme->rootobj];

    
  }
}

?>
