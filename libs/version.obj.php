<?php
 /**
  * Version object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */

class Version extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $version = NULL;
  public $flavour = NULL;
  public $cfg_version = NULL;
  public $description = NULL;
  public $scheme_id = -1;

  public $o_scheme = NULL;

  /* ctor */
  public function __construct($id=-1) 
  { 
    $this->id = $id;
    $this->_table = "version";
    $this->_my = array( 
			"version_id" => SQL_INDEX, 
		        "version" => SQL_PROPE,
			"flavour" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"cfg_version" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"scheme_id" => SQL_PROPE,
			"description" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"version_id" => "id", 
			"version" => "version",
			"flavour" => "flavour",
			"cfg_version" => "cfg_version",
			"scheme_id" => "scheme_id",
			"description" => "description"
 		 );
  }
}

?>
