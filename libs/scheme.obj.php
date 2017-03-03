<?php
 /**
  * Scheme object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */


class Scheme extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $tree = NULL;
  public $rootobj = NULL;
  public $tags = NULL;

  /* ctor */
  public function __construct($id=-1) 
  { 
    $this->id = $id;
    $this->_table = "scheme";
    $this->_my = array( 
			"scheme_id" => SQL_INDEX, 
		        "tree" => SQL_PROPE,
		        "rootobj" => SQL_PROPE,
		        "tags" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"scheme_id" => "id", 
			"tree" => "tree",
			"rootobj" => "rootobj",
			"tags" => "tags"
 		 );
  }
}

?>
