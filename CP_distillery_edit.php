<?php
session_start();
ob_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

use src\ProjectWhisky\business\WhiskyBusiness;
use src\ProjectWhisky\business\BarrelBusiness;
use src\ProjectWhisky\business\DistilleryBusiness;
use src\ProjectWhisky\business\UserBusiness;
use src\ProjectWhisky\exceptions\EmptyDataException;
use src\ProjectWhisky\exceptions\NoImageException;
use src\ProjectWhisky\exceptions\FuckedUpException;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php");
require_once("adminRights.php"); // Redirects users ir guest from control panel to index.php if is not admin

require_once('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("src");
$classLoader->register();

require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();


$distillery_id = isset($_GET["id"]) ? $_GET["id"] : "";

// Get Distillery Data
$distilleryBiz = new DistilleryBusiness();
$distillery_data = $distilleryBiz->getDistillery($distillery_id);

/**
 * Initiate $_SESSION['savedData'] and $_SESSION['distilleryMessage']
 */
if (!isset($_SESSION['savedData']))
{
    $_SESSION['savedData'] = array();
}
if(!isset($_SESSION['distilleryMessage']))
{
    $_SESSION['distilleryMessage'] = array();
}

// check for post
if(isset($_POST['distillerySaveBtn'])) {

    try {
    // set variables
    $_SESSION['savedData']['name'] = !empty($_POST["name"]) ? $_POST["name"] : "";
    $_SESSION['savedData']['address'] = !empty($_POST["address"]) ? $_POST["address"] : "";
    $_SESSION['savedData']['city'] = !empty($_POST["city"]) ? $_POST["city"] : "";
    $_SESSION['savedData']['country'] = !empty($_POST["country"]) ? $_POST["country"] : "";
    $_SESSION['savedData']['region'] = !empty($_POST["region"]) ? $_POST["region"] : "no region";
    $_SESSION['savedData']['distillery_id'] = $distillery_id;
    
    
    /**
         * If one of all fields is empty, throw an error
         */
        foreach ($_POST as $postLine)
        {
            if (empty($postLine)) throw new EmptyDataException();
        }
        
        // Update distillery
        $editDistillery = $distilleryBiz->editDistillery($_SESSION['savedData']['distillery_id'],
            $_SESSION['savedData']['name'],
            $_SESSION['savedData']['address'],
            $_SESSION['savedData']['city'],
            $_SESSION['savedData']['country'],
            $_SESSION['savedData']['region']);

        if ($editDistillery == false) throw new FuckedUpException();

        $_SESSION['distilleryMessage'] = "success";

        $updatedPath = "cp_distillery_edit.php?id=" . $distillery_id . "&updated=1";
        header("Location = $updatedPath");


    }
    catch (EmptyDataException $e)
    {
        $_SESSION['distilleryMessage'] = "missing";
    }
    catch (FuckedUpException $e)
    {
        $_SESSION['distilleryMessage'] = "error";
    }
}


// render TWIG
$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
$twig = new Twig_Environment($loader);

$view = $twig->render("cp_distillery_edit.twig", array("user" => $_SESSION['user'], "distillery" => $distillery_data, "msg" => $_SESSION['distilleryMessage']));

print($view);

/**
 * Handling messages removal and appearance
 */
if(isset($_SESSION['distilleryMessage']))
{
   $_SESSION['distilleryMessage'] = "";  
}    

if (isset($_GET['updated']) && (empty($_SESSION['distilleryMessage'])))
{
    $updatedPath = "CP_distillery_edit.php?id=" . $distillery_id;
    header("Location: $updatedPath");
}


if(isset($_GET['updated']) && ($_GET['updated'] == 1))
{
    $_SESSION['savedData'] = "";
   
}



ob_flush();