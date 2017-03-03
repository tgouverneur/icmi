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


class Job extends mysqlObj
{
  public $id = -1;		/* ID in the MySQL table */
  public $name = "";
  public $year = 2010;
  public $month = 00;
  public $day = 0;
  public $min = 0;
  public $hour = 0;
  public $function = "";
  public $recurent = 0;

  private $_icmid = null;
  private $_jlog = null;

  private function monitor()
  {
    /* fetching devices */
    $dlist = array();
    $index = "`device_id`";
    $table = "device";
    $where = "";
    $m = mysqlCM::getInstance();
    if ($m->connect()) {
      die($argv[0]." Error with SQL db: ".$m->getError()."\n");
    }
    if (($idx = $m->fetchIndex($index, $table, $where)))
    {
      foreach($idx as $t) {
        $d = new Device($t["device_id"]);
        $d->fetchFromId();
        $d->o_version = new Version($d->idversion);
        $d->o_version->fetchFromId();
        array_push($dlist, $d);
      }
    }

    foreach ($dlist as $d) {

      $this->_icmid->log("Checking device ".$d->hostname);
      /* check each device for its online/offline status */
      $url = ($d->https)?"https://":"http://";
      $url .= ($d->use_ip)?$d->address:$d->hostname.".".$d->domain;
      $url .= ":".$d->port;

      $curl = new Curl();
      $ret = $curl->get($url);
      if ($ret == FALSE) {
        $up = 0;
	$this->_icmid->log("CURL Error: ".$curl->getError());
      } else {
        $this->_icmid->log("curl rc=".$curl->getRC());
        switch ($curl->getRC()) {
		case 5:
		case 6:
		case 7:
        		$up = 0;
		break;
		default:
        		$up = 1;
		break;
	}
      }
      if ($d->online != $up) {
	$d->online = $up;
	$d->changed = date("U");
	$d->update();
        $this->_icmid->log("Device has been updated following modifications done");
      }
    }

  }

  public function runJob()
  {
    $this->_jlog = new JobLog();
    $this->_jlog->name = $this->name;
    $this->_jlog->function = $this->function;
    $this->_jlog->started_time = date("U");

    $ret = $this->{$this->function}();

    $this->_jlog->elapsed_time = date("U") - $this->_jlog->started_time;
    $this->_icmid->log("finished ".$this->function." Duration: ".$this->_jlog->elapsed_time." sec - rc=$ret");
    $this->_jlog->rc = $ret;

    /* Store job log */
    $r = $this->_jlog->insert();
    $this->_icmid->log("rc=$r id=".$this->id);
  }

  /* ctor */
  public function __construct($id=-1, $daemon)
  { 
    $this->id = $id;
    $this->_table = "jobs";
    $this->_icmid = $daemon;
    $this->_my = array( 
			"id" => SQL_INDEX, 
		        "name" => SQL_PROPE|SQL_EXIST|SQL_WHERE,
			"year" => SQL_PROPE,
			"month" => SQL_PROPE,
			"day" => SQL_PROPE,
			"min" => SQL_PROPE,
			"hour" => SQL_PROPE,
			"function" => SQL_PROPE,
			"recurent" => SQL_PROPE
 		 );


    $this->_myc = array( /* mysql => class */
			"id" => "id", 
			"name" => "name",
			"year" => "year",
			"month" => "month",
			"day" => "day",
			"min" => "min",
			"hour" => "hour",
			"function" => "function",
			"recurent" => "recurent"
 		 );
  }
}

?>
