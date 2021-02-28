<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$baseDir = dirname(__FILE__);

$namespaces = array(
    'Database\\' => array($baseDir . '/database'),
    'Model\\' => array($baseDir . '/model'),
    'Service\\' => array($baseDir . '/service'),
    'Controller\\' => array($baseDir . '/controller'),
    'Middleware\\' => array($baseDir . '/middleware'),
);

$loader = new \Composer\Autoload\ClassLoader();
foreach($namespaces as $key => $value) {
    $loader->setPsr4($key, $value);
}
$loader->register(true);

use Database\Database;

$dotEnv = new DotEnv(__DIR__);
$dotEnv->load();

$database = new Database();
$database = $database->getConnection();


