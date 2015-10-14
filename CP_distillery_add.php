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

$formData = array("name"=>"", "address"=>"", "city"=>"", "country"=>"", "region"=>"");
// check for post
if(count($_POST))
{  
    // set variables
    $name = $_POST["name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $region = !empty($_POST["region"]) ? $_POST["region"] : "no region";
    
    $formData = array("name"=>$name, "address"=>$address, "city"=>$city, "country"=>$country, "region"=>$region);
}

if(!empty($name) && !empty($address) && !empty($city) && !empty($country) && !empty($region))
{
    $distilleryBiz = new DistilleryBusiness();
    $addDistillery = $distilleryBiz->addDistillery($name, $address, $city, $country, $region);
    header("location:cp_distillery.php");
    
}
// render TWIG
$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
$twig = new Twig_Environment($loader);

$view = $twig->render("cp_distillery_add.twig", array("formData" => $formData));

print($view);




ob_flush();