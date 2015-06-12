<?php

// Database Settings
if (isset($_SERVER['MYSQL_PORT'])) {
  $database = new \Thru\ActiveRecord\DatabaseLayer(array(
    'db_type'     => 'Mysql',
    'db_hostname' => $_SERVER['MYSQL_1_ENV_TUTUM_NODE_FQDN'],
    'db_port'     => $_SERVER['MYSQL_1_PORT_3306_TCP_PORT'],
    'db_username' => $_SERVER['THRUIO_ENV_MYSQL_USER'],
    'db_password' => $_SERVER['THRUIO_ENV_MYSQL_PASS'],
    'db_database' => $_SERVER['THRUIO_ENV_MYSQL_DATABASE'],
  ));
} else {
  $database = new \Thru\ActiveRecord\DatabaseLayer(array(
    'db_type'     => 'Mysql',
    'db_hostname' => "localhost",
    'db_port'     => 3306,
    'db_username' => "bankingapp",
    'db_password' => "2l429q6Zug96iVU",
    'db_database' => "bankingapp",
  ));
}