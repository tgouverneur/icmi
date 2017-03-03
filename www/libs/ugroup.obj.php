<?php
 /**
  * UGroup object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */

require_once("./libs/mysqlobj.obj.php");

class UGroup extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $name = NULL;
  public $description = NULL;
  public $pages = NULL;

  /* ctor */
  public function __construct($id=-1) 
  { 
    $this->id = $id;
    $this->_table = "ugroup";
    $this->_my = array( 
			"ugroup_id" => SQL_INDEX, 
		        "name" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"description" => SQL_PROPE,
			"pages" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"ugroup_id" => "id", 
			"name" => "name",
			"description" => "description",
			"pages" => "pages"
 		 );
  }
}

?>
