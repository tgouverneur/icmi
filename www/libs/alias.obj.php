<?php
 /**
  * Alias object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2009, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */

require_once("./libs/mysqlobj.obj.php");

class Alias extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $name = NULL;
  public $address = NULL;
  public $global_f = 0;
  public $device_id = -1;

  /* ctor */
  public function __construct($id=-1) 
  { 
    $this->id = $id;
    $this->_table = "alias";
    $this->_my = array( 
			"alias_id" => SQL_INDEX, 
		        "name" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"address" => SQL_PROPE,
			"global_f" => SQL_PROPE,
			"device_id" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"alias_id" => "id", 
			"name" => "name", 
			"address" => "address", 
			"device_id" => "device_id"
 		 );
  }
}

?>
