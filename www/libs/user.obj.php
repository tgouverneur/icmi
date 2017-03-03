<?php
 /**
  * User object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */


class User extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $username = NULL;
  public $password = NULL;
  public $fullname = NULL;
  public $type = "A"; // admin per default
  public $device_id = -1;
  public $ugroup_id = -1;

  /* ctor */
  public function __construct($id=-1, $type="A") 
  { 
    $this->id = $id;
    $this->type = $type;
    $this->_table = "user";
    $this->_my = array( 
			"user_id" => SQL_INDEX, 
		        "username" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"password" => SQL_PROPE,
			"fullname" => SQL_PROPE,
			"type" => SQL_PROPE,
			"device_id" => SQL_PROPE,
			"ugroup_id" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"user_id" => "id", 
			"username" => "username",
			"password" => "password",
			"fullname" => "fullname",
			"type" => "type",
			"device_id" => "device_id",
			"ugroup_id" => "ugroup_id"
 		 );
  }
}

?>
