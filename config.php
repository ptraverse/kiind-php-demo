<?php
require 'vendor/autoload.php';

//Define OWLY_API_KEY and OWLY_BASE_URL
$owly_api_key_file = file_get_contents("./private/owly_api_key.json");
$owly_api_key_array = json_decode($owly_api_key_file, TRUE);
define("OWLY_API_KEY",(string)($owly_api_key_array['owly_api_key']));
define("OWLY_BASE_URL",(string)($owly_api_key_array['base_url']));

//Set up DBAL with Doctrine
$dbal_config = new \Doctrine\DBAL\Configuration();
//use private file with $connectionOptions array
include('private/mysql.php');
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionOptions, $dbal_config);


//EntityManager
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$paths = array(__DIR__.'/classes');
$isDevMode = false;
$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);

// registering noop annotation autoloader - allow all annotations by default
AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);
//use private file with $connectionOptions array
include('private/mysql.php');
$em = EntityManager::create($connectionOptions, $config);
//make sure db connection works!
try {
	$em->getConnection()->connect();
	$em->getConnection()->close();
	
} catch (\Exception $e) {
	var_dump($e);
	echo "\nNo Database Connection!\n";exit;
}
