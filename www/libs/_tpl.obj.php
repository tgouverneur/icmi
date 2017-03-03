<?php
 /**
  * Alias object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
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

  /* ctor */
  public function __construct($id=-1) 
  { 
    $this->id = $id;
    $this->_table = "alias";
    $this->_my = array( 
			"alias_id" => SQL_INDEX, 
		        "" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"alias_id" => "id", 
			"" => "",
			"" => "",
			"" => ""
 		 );
  }
}

?>
