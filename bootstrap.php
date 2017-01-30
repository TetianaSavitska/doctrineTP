<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths=["src/Entity"];
// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;

$dbParams=array(
	'driver' => 'pdo_mysql',
	'user' => 'root',
	'password' => '',
	'dbname' => 'doctrine_tp'
 	);


$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);


// obtaining the entity manager
$entityManager = EntityManager::create($dbParams, $config);

session_start();

if (isset($_SESSION['user'])){
	$_SESSION['user'] = $entityManager->merge($_SESSION['user']);
}