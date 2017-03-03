<?php
 /**
  * Daemon object
  * @author Gouverneur Thomas <tgo@ians.be>
  * @copyright Copyright (c) 2007-2008, Gouverneur Thomas
  * @version 1.0
  * @package objects
  * @subpackage device
  * @category classes
  * @filesource
  */


interface Daemonizable {

  public function run();
  public function start();
  public function cleanup();
  public function sigterm();
  public function sighup();
  public function sigkill();
  public function sigusr1();
  public function sigusr2();
}

class Daemon
{
  private $pid = 0;
  
  public function __construct($obj, $f) 
  { 
    if (!defined('SIGHUP')){
        trigger_error('PHP is compiled without --enable-pcntl directive', E_USER_ERROR);
    }
    pcntl_signal(SIGTERM,array($obj,'sigterm'));
    pcntl_signal(SIGHUP,array($obj,'sighup'));
    pcntl_signal(SIGUSR1,array($obj,'sigusr1')); 
    pcntl_signal(SIGUSR2,array($obj,'sigusr2')); 
 
    if (!$f) {

      $this->pid = pcntl_fork();
      if ($this->pid) {
        echo "Forked\n";
        exit(); // parent
      } else {
        $this->pid = posix_getpid();
        $obj->start();
        while(1) {
          if ($obj->run()) exit(0);
        }
      }
    } else {
      $obj->start();
      while(1) {
        if ($obj->run()) exit(0);
      }
    }
  }
}

?>
