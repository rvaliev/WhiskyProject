<?php
session_start();
ob_start(); 

error_reporting(E_ALL);
ini_set("display_errors", 1);

use src\ProjectWhisky\business\DistilleryBusiness;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php");
require_once("adminRights.php"); // Redirects users ir guest from control panel to index.php if is not admin

require_once('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("src");
$classLoader->register();

require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();

$distilleryBiz = new DistilleryBusiness;

if (isset($_GET['search_distilleryname']) && (!empty($_GET['search_distilleryname'])))
{
    
    $distilleryNameTrim = trim($_GET['search_distilleryname']);
    $distilleryList = $distilleryBiz->getDistilleriesByName($distilleryNameTrim);
    
    $loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
    $twig = new Twig_Environment($loader);
    
    $view = $twig->render("CP_distillery.twig", array("user" => $_SESSION['user'], "distilleries"=>$distilleryList, 'searchInput'=>$distilleryNameTrim));
    
}
else 
{

    $distilleryList = $distilleryBiz->getDistilleryList();
    
    $loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
    $twig = new Twig_Environment($loader);
    
    $view = $twig->render("CP_distillery.twig", array("user" => $_SESSION['user'], "distilleries"=>$distilleryList));

}
print($view);


ob_flush();