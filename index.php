<?php

/**
 * IMPORTANT: add following things in every controller:
 * session_start()
 * require_once("rolestarter.php");
 * "user" => $_SESSION['user'] needs to be sent to Twig
 */

session_start();

use src\ProjectWhisky\business\WhiskyBusiness;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php"); // gives to user role = 0 on first visit of the website: role = 0 - guest

/**
 * Connecting doctrine autoloader
 */
require_once'Doctrine/Common/ClassLoader.php';
$classLoader = new ClassLoader("src");
$classLoader->register();

require_once("lib/Twig/Autoloader.php"); 
Twig_Autoloader::register(); 

$whiskyList = new WhiskyBusiness();


$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation"); 
$twig = new Twig_Environment($loader); 
$view = $twig->render("home.twig", array( "whiskies" => $whiskyList->getWhiskyList(), "user" => $_SESSION['user']));
                         
print($view); 

