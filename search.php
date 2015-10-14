<?php
ob_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

use src\ProjectWhisky\business\WhiskyBusiness;
use src\ProjectWhisky\business\BarrelBusiness;
use src\ProjectWhisky\business\DistilleryBusiness;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php"); // gives to user role = 0 on first visit of the website: role = 0 - guest

require_once('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("src");
$classLoader->register();

require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();

if ((isset($_GET['strength_rangeleft'])) && (isset($_GET['strength_rangeright'])) && (isset($_GET['score_rangeleft'])) && (isset($_GET['score_rangeright']))
       && (isset($_GET['age_rangeright'])) && (isset($_GET['age_rangeright'])) && (isset($_GET['barrel_id'])) && (isset($_GET['region'])) )
{

    $whiskyBiz = new WhiskyBusiness();
    $whiskyList = $whiskyBiz->getWhiskyBySearch($_GET["barrel_id"], $_GET["strength_rangeleft"], $_GET["strength_rangeright"], $_GET["score_rangeleft"], $_GET["score_rangeright"], $_GET["region"],
    $_GET["age_rangeleft"], $_GET["age_rangeright"]);

    $BarrelBiz = new BarrelBusiness();
    $barrelList = $BarrelBiz->showAllBarrels();

    $distilleryBiz = new DistilleryBusiness();
    $regionList = $distilleryBiz->getRegionList();



    $loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
    $twig = new Twig_Environment($loader);

    $view = $twig->render("whisky_search_results.twig", array("user" => $_SESSION['user'], "whiskies" => $whiskyList,
                            "barrels" => $barrelList, "distilleries" => $regionList ));

    print($view);

}
else
{

    $whiskyBiz = new WhiskyBusiness();
    $whiskyList = $whiskyBiz->getWhiskyList();

    $BarrelBiz = new BarrelBusiness();
    $barrelList = $BarrelBiz->showAllBarrels();

    $distilleryBiz = new DistilleryBusiness();
    $regionList = $distilleryBiz->getRegionList();

    $loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
    $twig = new Twig_Environment($loader);

    $view = $twig->render("whisky_search.twig", array("user" => $_SESSION['user'], "whiskies" => $whiskyList,
                            "barrels" => $barrelList, "distilleries" => $regionList ));
    print($view);

}


ob_flush();

