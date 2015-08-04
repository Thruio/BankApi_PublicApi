<?php
require_once("bootstrap.php");
use Slim\Slim;
use Thru\ActiveRecord\ActiveRecord;
use \Thru\JsonPrettyPrinter\JsonPrettyPrinter;
use Thru\BankApi\Models\AccountHolder;
use Thru\BankApi\Models\Account;

$app = new Slim();

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

$app->get("/summary/:account_holder_name", function($account_holder_name) use ($app){
  $responseObjects = new \StdClass();

  /** @var AccountHolder $account_holder */
  $account_holder = AccountHolder::search()->where('name', $account_holder_name)->execOne();
  if(!$account_holder){
    $app->notFound();
  }

  // Calculate Totals.
  $responseObjects->total = 0;
  foreach($account_holder->getAccounts() as $account){
    $responseObjects->total += $account->getBalance()->value;
  }

  $response = $app->response();
  $response['Content-Type'] = 'application/json';
  $response->status(200);
  $response->body(JsonPrettyPrinter::json($responseObjects));
});

$app->get("/", function (){
  echo "Api documentation doesn't exist yet.";
});

$app->run();