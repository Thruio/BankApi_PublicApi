<?php
// Database Settings
if (isset($_ENV['DB_PORT'])) {
    $host = parse_url($_ENV['DB_PORT']);

    $database = new \Thru\ActiveRecord\DatabaseLayer(array(
    'db_type'     => 'Mysql',
    'db_hostname' => isset($host['hostname'])?$host['hostname']:$host['host'],
    'db_port'     => $host['port'],
    'db_username' => $_ENV['THRUIO_ENV_MYSQL_USER'],
    'db_password' => $_ENV['THRUIO_ENV_MYSQL_PASS'],
    'db_database' => $_ENV['THRUIO_ENV_MYSQL_DATABASE'],
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