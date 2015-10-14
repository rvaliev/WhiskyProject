<?php

session_start();

use src\ProjectWhisky\business\DistilleryBusiness;
use src\ProjectWhisky\business\WhiskyBusiness;
use Doctrine\Common\ClassLoader;

/**
 * Connecting doctrine autoloader
 */
require_once'Doctrine/Common/ClassLoader.php';
$classLoader = new ClassLoader("src");
$classLoader->register();
/* Twig autoloader*/
require_once("lib/Twig/Autoloader.php"); 
Twig_Autoloader::register(); 

$distilleryBiz = new DistilleryBusiness();
$whiskyBiz = new WhiskyBusiness();
$distillery = $distilleryBiz->getDistillery($_GET["id"]);
$whiskies = $whiskyBiz->getWhiskyByDistillery($_GET["id"]);
/*
print("<pre>");
print_r($distillery);
print("</pre>");
*/
$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation"); 
$twig = new Twig_Environment($loader); 
$view = $twig->render("distillery_page.twig", array("user" => $_SESSION['user'],  "distillery" => $distillery, "whiskies" => $whiskies));

print($view); 