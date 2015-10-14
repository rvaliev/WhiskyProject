<?php
session_start();
ob_start(); 

error_reporting(E_ALL);
ini_set("display_errors", 1);


use src\ProjectWhisky\business\WhiskyBusiness;
use src\ProjectWhisky\business\BarrelBusiness;
use src\ProjectWhisky\business\DistilleryBusiness;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php");
require_once("adminRights.php"); // Redirects users ir guest from control panel to index.php if is not admin



require_once('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("src");
$classLoader->register();


require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();

if (!isset($_SESSION['whiskyMessage']))
{
    $_SESSION['whiskyMessage'] = "";
}

$whiskyBiz = new WhiskyBusiness;

if (isset($_GET['whiskyname']) && (!empty($_GET['whiskyname'])))
{
    $whiskynameTrim = trim($_GET['whiskyname']);
	$whiskyList = $whiskyBiz->getWhiskiesByName($whiskynameTrim);
	
	$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
	$twig = new Twig_Environment($loader);

	$view = $twig->render("CP_whisky.twig", array("user" => $_SESSION['user'], "whiskies"=>$whiskyList, "searchInput"=>$whiskynameTrim));
	
}
else
{
	
	$whiskyList = $whiskyBiz->getWhiskyList();
	
	
	$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
	$twig = new Twig_Environment($loader);

	$view = $twig->render("CP_whisky.twig", array("user" => $_SESSION['user'], "whiskies"=>$whiskyList, "msg" => $_SESSION['whiskyMessage']));
}

print($view);


/**
 * Handling messages removal and appearance
 */
if (isset($_GET['updated']) && (empty($_SESSION['whiskyMessage'])))
{
	header("Location: CP_whisky.php");
}


if(isset($_GET['updated']) && ($_GET['updated'] == 1))
{
	$_SESSION['savedData'] = "";
	$_SESSION['whiskyMessage'] = "";
}



ob_flush();