<?php
session_start();
ob_start(); 

error_reporting(E_ALL);
ini_set("display_errors", 1);

use src\ProjectWhisky\business\UserBusiness;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php");
require_once("adminRights.php"); // Redirects users ir guest from control panel to index.php if is not admin

require_once('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("src");
$classLoader->register();

require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();

$userBiz = new UserBusiness;

if (isset($_GET['search_username']) && (!empty($_GET['search_username'])))
{
    
    $usernameTrim = trim($_GET['search_username']);
    
    $userlist = $userBiz->getUsersByUsername($usernameTrim);
    
    $loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
    $twig = new Twig_Environment($loader);

    $view = $twig->render("CP_user.twig", array("user" => $_SESSION['user'], "users"=>$userlist, "searchInputUsername"=>$usernameTrim));
    
}
else {
    
    $userlist = $userBiz->getAllUsers();

    $loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
    $twig = new Twig_Environment($loader);

    $view = $twig->render("CP_user.twig", array("user" => $_SESSION['user'], "users"=>$userlist));
    
}





print($view);




ob_flush();