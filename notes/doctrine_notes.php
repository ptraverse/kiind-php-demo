//Using Doctrine to do Connections to Database

//Install via Composer
Add to composer.json: "doctrine/orm": "2.4.6"

//Configure - Add these linese to config.php (aka bootstrap file)
/* START */ <?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
$paths = array(__DIR__.'/classes');
$isDevMode = false;
$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);
AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);
$connectionOptions = array(
	'dbname' => 'qp',
	'user' => 'root',
	'password' => '',
	'host' => 'localhost',
	'driver' => 'pdo_mysql',
);
$em = EntityManager::create($connectionOptions, $config); //$em aka EntityManager does all the DB "units of work"
?>/* END */

//Register Entities
Add @ORM/Entity Docblocks to classes

//Create Database Tables
vendor/bin/doctrine orm:schema-tool:create --dump-sql

//INSERT/UPDATE via $em->persist();$em->flush(); e.g: 
/*START*/ <?php 
$user = new User($email,$password,$password_confirm);
$exists = $em->getRepository('User')->findOneBy(array('email' => $email));
if ($exists==FALSE)
{
	$em->persist($user);
	$em->flush();			
	echo "\tNew User ID ".$user->id." Created! Your New Pin is: \n\t\t\t".$user->pin."\n\n";
}
else
{
	echo "User With Email ".$exists->email." already exists! \n";
}
?>/* END */
