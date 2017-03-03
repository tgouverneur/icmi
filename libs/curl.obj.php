<?php
 /**
  * Curl browser
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */

/**
 * Class to use curl
 */
class Curl
{
  private $_cm = NULL;
  private $_username; 
  private $_password; 

  private $_error;
  private $_rc;
  
 /**
  * Constructor - init the CURL object
  */
  public function __construct() {
    $this->init();
  }

 /**
  * Set the password for authentication
  */
  public function setPassword($p) {
    $this->_password = $p;
  }

 /**
  * Set the username for authentication
  */
  public function setUsername($l) {
    $this->_username = $l;
  }

 /**
  * Initialize the curl library
  */
  private function init() {
    $this->_cm = curl_init();
    curl_setopt($this->_cm, CURLOPT_PROXY, $config['curl']['proxy']);
    curl_setopt($this->_cm, CURLOPT_HTTPAUTH, CURLAUTH_BASIC | CURLAUTH_DIGEST);
    curl_setopt($this->_cm, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($this->_cm, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($this->_cm, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($this->_cm, CURLOPT_TIMEOUT, $config['curl']['timeout']);
    curl_setopt($this->_cm, CURLOPT_POST, true); 
  }

 /**
  * Exec a POST request and don't return the result, only HTTP code
  * @return HTTP code of request
  */
  public function sendFile($url, $fields) {

    $this->_error = NULL;
    $this->_rc = NULL;

    curl_setopt($this->_cm, CURLOPT_USERPWD, $this->_username.":".$this->_password);
    curl_setopt($this->_cm, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($cm, CURLOPT_URL, $url);

    $res = curl_exec($this->_cm);
    if ($res == FALSE) {
      $this->_error = curl_error($this->_cm);
      $res = -1;
    } else {
      $this->_rc = curl_getinfo($this->_cm, CURLINFO_HTTP_CODE);
      $res = $this->_rc;
    }
    curl_close($this->_cm);
    return $res;
  }
 
 /**
  * Return the result of POST request
  * @return whole http response
  */
  public function get($url, $fields="") {

    $this->_error = NULL;
    $this->_rc = NULL;

    curl_setopt($this->_cm, CURLOPT_USERPWD, $this->_username.":".$this->_password);
    curl_setopt($this->_cm, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($this->_cm, CURLOPT_URL, $url);

    $res = curl_exec($this->_cm);
    if ($res == FALSE) {
      $this->_error = curl_error($this->_cm);
      $this->_rc = curl_errno($this->_cm);
    } else {
      $this->_rc = curl_getinfo($this->_cm, CURLINFO_HTTP_CODE);
    }
    curl_close($this->_cm);
    return $res;
  }

 /**
  * Get the error of latest query
  * @return error message of latest query
  */
  public function getError() {
    return $this->_error;
  }

 /**
  * Return the HTTP code of last request
  * @return HTTP code
  */
  public function getRc() {
    return $this->_rc;
  }
}
?>
