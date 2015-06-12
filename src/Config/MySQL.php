<?php
$settings = array_merge($_ENV, $_SERVER);
// Database Settings
if (isset($settings['THRUIO_ENV_MYSQL_DATABASE'])) {
  $database = new \Thru\ActiveRecord\DatabaseLayer(array(
    'db_type'     => 'Mysql',
    'db_hostname' => $settings['MYSQL_1_ENV_TUTUM_NODE_FQDN'],
    'db_port'     => $settings['MYSQL_1_PORT_3306_TCP_PORT'],
    'db_username' => $settings['THRUIO_ENV_MYSQL_USER'],
    'db_password' => $settings['THRUIO_ENV_MYSQL_PASS'],
    'db_database' => $settings['THRUIO_ENV_MYSQL_DATABASE'],
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