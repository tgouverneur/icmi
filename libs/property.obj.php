<?php
 /**
  * Property object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */

require_once("./libs/mysqlobj.obj.php");

class Property extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $name = NULL;
  public $type = NULL;
  public $value = NULL;
  public $parent_id = -1;
  public $device_id = -1;

  /* ctor */
  public function __construct($id=-1) 
  { 
    $this->id = $id;
    $this->_table = "property";
    $this->_my = array( 
			"property_id" => SQL_INDEX, 
		        "name" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"type" => SQL_PROPE,
			"value" => SQL_PROPE,
			"parent_id" => SQL_PROPE,
			"device_id" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"property_id" => "id", 
			"name" => "name",
			"type" => "type",
			"value" => "value",
			"parent_id" => "parent_id",
			"device_id" => "device_id"
 		 );
  }
}

?>
