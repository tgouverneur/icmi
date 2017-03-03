<?php
 /**
  * Job object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage job
  * @category classes
  * @filesource
  */


class JobLog extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $name = "";
  public $function = "";
  public $rc = 0;
  public $elapsed_time = 0;
  public $started_time = 0;

  /* ctor */
  public function __construct($id=-1)
  { 
    $this->id = $id;
    $this->_table = "joblogs";
    $this->_my = array( 
			"id" => SQL_INDEX, 
		        "name" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"rc" => SQL_PROPE,
			"elapsed_time" => SQL_PROPE,
			"started_time" => SQL_PROPE,
			"function" => SQL_PROPE,
 		 );


    $this->_myc = array( /* mysql => class */
			"id" => "id", 
			"name" => "name",
			"rc" => "rc",
			"elapsed_time" => "elapsed_time",
			"started_time" => "started_time",
			"function" => "function"
 		 );
  }
}

?>
