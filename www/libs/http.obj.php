<?php
/**
 * HTTP class
 *
 * @author Gouverneur Thomas <tgo@ians.be>
 * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
 * @version 1.0
 * @package libs
 * @subpackage various
 * @category libs
 * @filesource
 */


class HTTP
{
  private static $_instance;    /* instance of the class */

 /**
  * return the instance of HTTP object
  */
  public static function getInstance()
  { 
    if (!isset(self::$_instance)) {
     $c = __CLASS__;
     self::$_instance = new $c;
    }
    return self::$_instance;
  }

 /**
  * Avoid the __clone method to be called
  */
  public function __clone()
  { 
    trigger_error("Cannot clone a singlton object, use ::instance()", E_USER_ERROR);
  }

 /**
  * Get the http post/get variable
  * @arg Name of the variable to get
  * @return the variable, with POST->GET priority
  */
  public function getHTTPVar($name) {
    global $_GET, $_POST;
   
    /* first check POST, then fallback on GET */
    if (isset($_POST[$name])) return $_POST[$name];
    if (isset($_GET[$name])) return $_GET[$name];
    return NULL;
  }

 /**
  * Sanitize an array by escaping the strings inside.
  * @arg Name of the variable to sanitize
  */
  public function sanitizeArray($var) {

    foreach($var as $name => $value) {

      if (is_array($value)) { 
        sanitizeArray($value); 
        continue; 
      }

      $var[$name] = mysql_escape_string($value);

    }
  }

}

?>
