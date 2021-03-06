<?php
session_start();
ob_start(); 

error_reporting(E_ALL);
ini_set("display_errors", 1);

use src\ProjectWhisky\business\BarrelBusiness;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php");
require_once("adminRights.php"); // Redirects users ir guest from control panel to index.php if is not admin

require_once('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("src");
$classLoader->register();

require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();

// check form submit
if(isset($_POST["type"]))
{
    $type = $_POST["type"];
    $barrelBiz = new BarrelBusiness();
    $editBarrel = $barrelBiz->addBarrel($type);
    header("location:cp_barrel.php");
}    

// render TWIG
$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
$twig = new Twig_Environment($loader);

$view = $twig->render("cp_barrel_add.twig");

print($view);




ob_flush();