<?php
/**
 * Library for autoloading object dependancies at runtime
 *
 * @author Gouverneur Thomas <tgo@ians.be>
 * @copyright Copyright (c) 2007-2009, Gouverneur Thomas
 * @version 1.0
 * @package libs
 * @subpackage various
 * @category libs
 * @filesource
 */

function __autoload($name) {
 global $config;

 $name = strtolower($name);
 if (isset($config['rootpath'])) {
   $file = $config['rootpath']."/";
 }
 $file .= "./libs/".$name.".obj.php";
 if (file_exists($file)) {
   require_once($file);
 } else {
   trigger_error("Cannot load $file...\n", E_USER_ERROR);
 }
}
?>
