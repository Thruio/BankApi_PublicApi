<?php

namespace Thru\Bank\Models;

use Monolog\Logger;
use Thru\ActiveRecord\ActiveRecord;

/**
 * Class Run
 * @var $run_id integer
 * @var $started date
 * @var $ended date
 * @var $exec_time integer
 * @var $created date
 * @var $updated date
 */
class Run extends ActiveRecord{

  protected $_table = "runs";

  public $run_id;
  public $started;
  public $ended;
  public $exec_time;
  public $created;
  public $updated;

  /** @var Logger */
  private $_logger;

  public function __construct(){
    parent::__construct();
    $this->started = date("Y-m-d H:i:s");
    $this->ended = date("Y-m-d H:i:s");
    $this->exec_time = 0;
    $this->created = date("Y-m-d H:i:s");
    $this->updated = date("Y-m-d H:i:s");
  }

  public function save(){
    $this->updated = date("Y-m-d H:i:s");
    if(!$this->created){
      $this->created = date("Y-m-d H:i:s");
    }
    parent::save();
  }

  public function end(){
    $this->ended = date("Y-m-d H:i:s");
    $this->exec_time = strtotime($this->ended) - strtotime($this->started);
    $this->save();
  }

  public function setLogger(Logger $logger){
    $this->_logger = $logger;
    return $this;
  }

  public function getLogger(){
    return $this->_logger;
  }
}
