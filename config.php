<?php

require 'vendor/autoload.php';


/*********************************************
 * Logging
*********************************************/

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$debug = new Logger('debug');
$debug->pushHandler(new StreamHandler('log/debug.log', Logger::DEBUG));

/* e.g, add records to the log */
// $debug->addDebug($_SERVER['REQUEST_URI'],array('foo'=>'bar','baz'=>'123asdf'));



/*********************************************
 * Session Manager
*********************************************/

use Symfony\Component\HttpFoundation\Session\Session;
$session = new Session();
$session->start();

/* eg. set and get session attributes */
// $session->set('name', 'Drak');
// $debug->addDebug($session->get('name'),array("sessionGetName"));

/* eg. set flash messages */
// $session->getFlashBag()->add('notice', 'Profile updated');

/* eg. retrieve messages */
// foreach ($session->getFlashBag()->get('notice', array()) as $message) {
//     echo '<div class="flash-notice">'.$message.'</div>';
// }



/*********************************************
 * UserAuth Manager - Cartalyst/Sentry
*********************************************/
// Import the necessary classes
use Illuminate\Database\Capsule\Manager as Capsule;

// Create the Sentry alias
class_alias('Cartalyst\Sentry\Facades\Native\Sentry', 'Sentry');

// Create a new Database connection (Sentry-specific!)
$capsule = new Capsule;

$capsule->addConnection([
		'driver'    => 'mysql',
		'host'      => 'localhost',
		'database'  => 'qp',
		'username'  => 'root',
		'password'  => '',
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		]);

$capsule->bootEloquent();

/*********************************************
 * DB Connections
*********************************************/

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

// e.g. Create a User object, Check if Exists, Save it to the Database
// $user = new User($email,$password,$password_confirm);
// $exists = $em->getRepository('User')->findOneBy(array('email' => $email));
// if ($exists==FALSE)
// {
// 	$em->persist($user);
// 	$em->flush();
// }

//make sure db connection works!
try {
	$em->getConnection()->connect();
	$em->getConnection()->close();
} catch (\Exception $e) {
	throw new Exception("No Database Connection!","500");
}

/*********************************************
 * API Keys
*********************************************/

//Define OWLY_API_KEY and OWLY_BASE_URL
$owly_api_key_file = file_get_contents("./private/owly_api_key.json");
$owly_api_key_array = json_decode($owly_api_key_file, TRUE);
define("OWLY_API_KEY",(string)($owly_api_key_array['owly_api_key']));
define("OWLY_BASE_URL",(string)($owly_api_key_array['base_url']));

//Define KIIND_CLIENT_ID, KIIND_CLIENT_SECRET, KIIND_BASE_URL
$kiind_api_key_file = file_get_contents("./private/kiind_api_key.json");
$kiind_api_key_array = json_decode($kiind_api_key_file, TRUE);
define("KIIND_CLIENT_ID",(string)($kiind_api_key_array['client_id']));
define("KIIND_CLIENT_SECRET",(string)($kiind_api_key_array['client_secret']));
define("KIIND_BASE_URL",(string)($kiind_api_key_array['base_url']));
define("KIIND_REDIRECT_URI",(string)($kiind_api_key_array['redirect_uri']));


/*********************************************
 * Routing
*********************************************/
require_once('glue.php');


/*********************************************
 * Twig Templates 
*********************************************/
$loader = new Twig_Loader_Filesystem("./templates");
$twig = new Twig_Environment($loader);

/*********************************************
 * Development Settings
*********************************************/

if (file_exists('./private/config_override.php'))
{
	require_once('./private/config_override.php');
}

