<?php

namespace Thru\Bank\Models;

use Thru\ActiveRecord\ActiveRecord;

/**
 * Class Account
 * @var $account_id integer
 * @var $name text
 * @var $created date
 * @var $updated date
 * @var $last_check date
 */
class Account extends ActiveRecord{

  protected $_table = "accounts";

  public $account_id;
  public $name;
  public $created;
  public $updated;
  public $last_check;

  /**
   * @param $name
   * @return Account
   */
  static public function FetchOrCreateByName($name){
    $account = Account::factory()->search()->where('name', $name)->execOne();
    if(!$account){
      $account = new Account();
      $account->name = $name;
      $account->save();
    }
    return $account;
  }

  public function save(){
    $this->updated = date("Y-m-d H:i:s");
    if(!$this->created){
      $this->created = date("Y-m-d H:i:s");
    }
    if(!$this->last_check){
      $this->last_check = date("Y-m-d H:i:s", 0);
    }
    parent::save();
  }


}
