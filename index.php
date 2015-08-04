<?php
require_once("bootstrap.php");
use Slim\Slim;
use Thru\ActiveRecord\ActiveRecord;
use \Thru\JsonPrettyPrinter\JsonPrettyPrinter;
use Thru\BankApi\Models\AccountHolder;
use Thru\BankApi\Models\Account;

error_reporting(E_ALL);
ini_set('display_errors',1);

$app = new Slim();

$app->get("/summary/:account_holder_name", function($account_holder_name) use ($app){
  $responseObjects = new StdClass();

  /** @var AccountHolder $account_holder */
  $account_holder = AccountHolder::search()->where('name', $account_holder_name)->execOne();
  if(!$account_holder){
    $app->notFound();
  }

  // Calculate Totals.
  $responseObjects->total = 0;
  $responseObjects->balances = [];
  $responseObjects->lastUpdated = null;
  foreach($account_holder->getAccounts() as $account){
    $nameHash = substr(md5($account->name),0,7);
    $nameCleaned = trim(preg_replace("/\\([^)]+\\)/","",$account->name));
    $displayName = "({$nameHash}) {$nameCleaned}";

    $balance = $account->getBalance();
    if($balance) {
      $responseObjects->total += $balance->value;
      $responseObjects->balances[$displayName] = $balance->value;
      if(strtotime($balance->getRun()->updated) > strtotime($responseObjects->lastUpdated)) {
        $responseObjects->lastUpdated = $balance->getRun()->updated;
      }
    }else{
      $responseObjects->balances[$displayName] = "Unavailable";
    }

  }

  $response = $app->response();
  $response['Content-Type'] = 'application/json';
  $response->status(200);
  $response->body(JsonPrettyPrinter::json($responseObjects));
});

// List function
$app->get('/:model', function ($model) use ($app) {
  $modelName = "\\Thru\\BankApi\\Models\\" . $model;
  if(class_exists($modelName)){
    /** @var ActiveRecord $o */
    $o = new $modelName;
    $list = $o->search()->exec();
    $responseObjects = [];
    foreach($list as $item){
      /** @var ActiveRecord $item  */
      $responseObjects[] = $item->__toPublicArray();
    }

    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->status(200);
    $response->body(JsonPrettyPrinter::json($responseObjects));

  }else{
    $app->notFound();
  }
});

// fetch function
$app->get('/:model/:id', function ($model, $id) {

});

$app->get("/", function (){
  echo "Api documentation doesn't exist yet.";
});

$app->run();