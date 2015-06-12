<?php

namespace Thru\Bank\Models;

use Thru\ActiveRecord\ActiveRecord;

/**
 * Class Balance
 * @var $transaction_id integer
 * @var $account_id integer
 * @var $run_id integer
 * @var $name text
 * @var $value text
 * @var $state ENUM("Complete","Pending")
 * @var $occured date
 * @var $created date
 * @var $updated date
 */
class Transaction extends ActiveRecord{

  protected $_table = "transactions";

  public $transaction_id;
  public $account_id;
  public $run_id;
  public $name;
  public $value;
  public $state = "Complete";
  public $occured;
  public $created;
  public $updated;

  public function save(){
    $this->updated = date("Y-m-d H:i:s");
    if(!$this->created){
      $this->created = date("Y-m-d H:i:s");
    }
    parent::save();
  }

  /**
   * @param Run $run
   * @param Account $account
   * @param $merchantName
   * @param $date
   * @param $value
   * @return Transaction
   */
  public static function Create(Run $run, Account $account, $merchantName, $date, $value, $state = "Completed"){

    $value = doubleval(preg_replace("/[^0-9,.]/", "", trim($value)));

    $transaction = Transaction::search()
      ->where('account_id', $account->account_id)
      ->where('name', $merchantName)
      ->where('occured', $date)
      ->where('value', $value)
      ->execOne();

    if(!$transaction) {
      $transaction = new Transaction();
      $transaction->run_id = $run->run_id;
      $transaction->account_id = $account->account_id;
      $transaction->name = $merchantName;
      $transaction->occured = $date;
      $transaction->value = $value;
      $transaction->state = $state;
      $transaction->save();
      echo "New Transaction.\n";
      $run->getLogger()->addInfo("New transaction: {$transaction->name} {$transaction->value} at {$transaction->occured}");
    }else{
      echo "Already Exists.\n";
    }
    return $transaction;
  }
}
