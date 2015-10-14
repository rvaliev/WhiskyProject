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
$msg = "";



/**
 * Initiate $_SESSION['savedData'] and $_SESSION['whiskyMessage']
 */
if (!isset($_SESSION['savedData']))
{
    $_SESSION['savedData'] = array();
    $_SESSION['whiskyMessage'] = array();
}


/**
 * Save new whisky
 */
if(isset($_POST['whiskySaveBtn'])) {
    try {
        $_SESSION['savedData']['name'] = !empty($_POST["whisky_name"]) ? $_POST["whisky_name"] : "";
        $_SESSION['savedData']['distillery'] = !empty($_POST["distillery_id"]) ? $_POST["distillery_id"] : "";
        $_SESSION['savedData']['image'] = !empty($_FILES["whisky_image"]["name"]) ? $_FILES["whisky_image"] : "default.jpg";
        $_SESSION['savedData']['price'] = !empty($_POST["whisky_price"]) ? $_POST["whisky_price"] : "";
        $_SESSION['savedData']['age'] = !empty($_POST["whisky_age"]) ? $_POST["whisky_age"] : "";
        $_SESSION['savedData']['strength'] = !empty($_POST["whisky_strength"]) ? $_POST["whisky_strength"] : "";
        $_SESSION['savedData']['barrel_id'] = !empty($_POST["barrel"]) ? $_POST["barrel"] : "";
        $_SESSION['savedData']['rating_aroma'] = !empty($_POST["rating_aroma"]) ? $_POST["rating_aroma"] : "";
        $_SESSION['savedData']['rating_color'] = !empty($_POST["rating_color"]) ? $_POST["rating_color"] : "";
        $_SESSION['savedData']['rating_taste'] = !empty($_POST["rating_taste"]) ? $_POST["rating_taste"] : "";
        $_SESSION['savedData']['rating_aftertaste'] = !empty($_POST["rating_aftertaste"]) ? $_POST["rating_aftertaste"] : "";
        $_SESSION['savedData']['text_aroma'] = !empty($_POST["text_aroma"]) ? $_POST["text_aroma"] : "";
        $_SESSION['savedData']['text_color'] = !empty($_POST["text_color"]) ? $_POST["text_color"] : "";
        $_SESSION['savedData']['text_taste'] = !empty($_POST["text_taste"]) ? $_POST["text_taste"] : "";
        $_SESSION['savedData']['text_aftertaste'] = !empty($_POST["text_aftertaste"]) ? $_POST["text_aftertaste"] : "";
        $_SESSION['savedData']['review'] = !empty($_POST["text_review"]) ? $_POST["text_review"] : "";
        $_SESSION['savedData']['user_id'] = $_SESSION["user"]["id"];

        /**
         * If one of all fields is empty, throw an error
         */
        foreach ($_POST as $postLine)
        {
            if (empty($postLine)) throw new EmptyDataException();
        }

        /**
         * If no image was selected, throw an error
         */
        if (empty($_FILES['whisky_image']['name'])) throw new NoImageException();


        $newImagePath = "";

        /**
         * Upload image
         */
        if (isset($_FILES['whisky_image']))
        {
            $file = $_FILES['whisky_image'];

            /**
             * File properties
             */
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_size = $file['size'];
            $file_error = $file['error'];

            /**
             * Work out the file extension
             * If move_uploaded_file gives permission error, 'cd' to 'userimages' folder and give it wright permissions: 'chmod 0777 userimages' (both machines)
             */
            $file_ext = explode('.', $file_name);
            $file_ext = strtolower(end($file_ext));

            /**
             * Define allowed file extensions
             */
            $allowed = array('png', 'jpg', 'jpeg', 'gif');

            if (in_array($file_ext, $allowed))
            {
                if ($file_error === 0)
                {
                    if ($file_size <= 2097152)
                    {
                        $file_name_new = uniqid('', true) . '.' . $file_ext; // uniqid - creates unique id based on current timestamp in microseconds


                        $file_destination = 'src/ProjectWhisky/presentation/img/' . $file_name_new;

                        if (move_uploaded_file($file_tmp, $file_destination))
                        {
                            $newImagePath = $file_name_new;
                            /**
                             * Calling defined function and giving parameters. $profile is an object
                             */
//                            updateImagePathInDB($userId, $newImagePath, $profile);

                            /*if($userData['image_path'] !== "default.jpg")
                            {
                                $toRemoveImage = "src/ProjectWhisky/presentation/img/" . $userData['image_path'];
                                unlink($toRemoveImage);
                            }*/

                        }
                    }
                    else
                    {
                        $_SESSION['whiskyMessage'] = "Allowed file size is 2MB";
                    }
                }
            }
            else
            {
                $_SESSION['whiskyMessage'] = "Only .png, .jpg, .jpeg and .gif files are allowed.";
            }
        }


        $hidden = 0;

        $_SESSION['savedData']['rating_aroma'] = $_SESSION['savedData']['rating_aroma'] * 2;
        $_SESSION['savedData']['rating_color'] = $_SESSION['savedData']['rating_color'] * 2;
        $_SESSION['savedData']['rating_taste'] = $_SESSION['savedData']['rating_taste'] * 2; 
        $_SESSION['savedData']['rating_aftertaste'] = $_SESSION['savedData']['rating_aftertaste'] * 2;

        // Add whisky to DB
        $whiskyBiz = new WhiskyBusiness();
        $addWhisky = $whiskyBiz->addWhisky($_SESSION['savedData']['name'],
                        $_SESSION['savedData']['distillery'],
                        $_SESSION['savedData']['price'],
                        $_SESSION['savedData']['age'],
                        $_SESSION['savedData']['strength'],
                        $_SESSION['savedData']['barrel_id'],
                        $newImagePath,
                        $hidden,
                        $_SESSION['savedData']['rating_aroma'],
                        $_SESSION['savedData']['rating_color'],
                        $_SESSION['savedData']['rating_taste'],
                        $_SESSION['savedData']['rating_aftertaste'],
                        $_SESSION['savedData']['text_aroma'],
                        $_SESSION['savedData']['text_color'],
                        $_SESSION['savedData']['text_taste'],
                        $_SESSION['savedData']['text_aftertaste'],
                        $_SESSION['savedData']['review'],
                        $_SESSION['savedData']['user_id']);

        if ($addWhisky == false) throw new FuckedUpException();

        $_SESSION['whiskyMessage'] = "success";

        header("Location: CP_whisky_add.php?updated=1");

    }
    catch (EmptyDataException $e)
    {
        $_SESSION['whiskyMessage'] = "missing";
    }
    catch (NoImageException $e)
    {
        $_SESSION['whiskyMessage'] = "image_missing";
    }
    catch (FuckedUpException $e)
    {
        $_SESSION['whiskyMessage'] = "error";
    }


}


// Get distillery data
$distilleryBiz = new DistilleryBusiness();
$distillery_data = $distilleryBiz->getDistilleryList();

// Get Barrel Data
$barrelBiz = new BarrelBusiness();
$barrel_data = $barrelBiz->showAllBarrels();

$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
$twig = new Twig_Environment($loader);

$view = $twig->render("CP_whisky_add.twig", array("user" => $_SESSION['user'], "distilleries" => $distillery_data, "barrels" => $barrel_data, "msg" => $_SESSION['whiskyMessage'], "savedData" => $_SESSION['savedData']));

print($view);







/**
 * Handling messages removal and appearance
 */
if (isset($_GET['updated']) && (empty($_SESSION['whiskyMessage'])))
{
    header('Location: CP_whisky_add.php');
}


if(isset($_GET['updated']) && ($_GET['updated'] == 1))
{
    $_SESSION['savedData'] = "";
    $_SESSION['whiskyMessage'] = "";
}





ob_flush();
