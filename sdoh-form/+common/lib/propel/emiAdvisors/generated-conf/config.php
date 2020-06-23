<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../../../config/config.inc.php');
global $config;

$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('emi_advisors', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => sprintf("mysql:host=%s;port=%s;dbname=%s", $config['mysql']['host'], '3306', $config['mysql']['dbname']),
  'user' => $config['mysql']['username'],
  'password' => $config['mysql']['password'],
  'settings' =>
  array (
    'charset' => 'utf8',
    'queries' =>
    array (
    ),
  ),
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$manager->setName('emi_advisors');
$serviceContainer->setConnectionManager('emi_advisors', $manager);
$serviceContainer->setDefaultDatasource('emi_advisors');