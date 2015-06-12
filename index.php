<?php
require_once("bootstrap.php");
use Slim\Slim;
use Thru\ActiveRecord\ActiveRecord;
use \Thru\JsonPrettyPrinter\JsonPrettyPrinter;

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


$app->run();