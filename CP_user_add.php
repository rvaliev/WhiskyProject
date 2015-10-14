<?php
session_start();
ob_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

use src\ProjectWhisky\business\UserBusiness;
use src\ProjectWhisky\business\ProfileBusiness;
use src\ProjectWhisky\helpers\ValidationHelpers;
use src\ProjectWhisky\exceptions\ImageException;
use src\ProjectWhisky\exceptions\UserExistsException;
use src\ProjectWhisky\exceptions\EmptyDataException;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php");
require_once("adminRights.php"); // Redirects users ir guest from control panel to index.php if is not admin

require_once('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("src");
$classLoader->register();

require_once("lib/Twig/Autoloader.php");
Twig_Autoloader::register();

// check form submit
if(isset($_POST["userUsername"]))
{
    try
    {
        $userBiz = new UserBusiness();

        //form POST data
        $_SESSION['savedData']['username'] = $_POST['userUsername'];
        $_SESSION['savedData']['password'] = $_POST['userPassword'];
        $_SESSION['savedData']['email'] = $_POST['userEmail'];
        $_SESSION['savedData']['firstname'] = $_POST['userFirstName'];
        $_SESSION['savedData']['lastname'] = $_POST['userLastName'];

        $_SESSION['savedData']['admin'] = false;
        if(isset($_POST['userAdmin']))
        {
            $_SESSION['savedData']['admin'] = true;
        }

        $_SESSION['savedData']['blocked'] = false;
        if(isset($_POST['userBlocked']))
        {
            $_SESSION['savedData']['blocked'] = true;
        }


        if(empty($_SESSION['savedData']['username']) || empty($_SESSION['savedData']['password']) || empty($_SESSION['savedData']['email']) || empty($_SESSION['savedData']['firstname']) || empty($_SESSION['savedData']['lastname']))
        {
            throw new EmptyDataException("missing");
        }

        /**
         * Validate data
         */
        $validator = new ValidationHelpers();
        if(($validator->validateEmail($_SESSION['savedData']['email'])) == false) throw new EmptyDataException("wrong_email_pattern");
        if((($validator->validateName($_SESSION['savedData']['firstname'])) == false) || (($validator->validateName($_SESSION['savedData']['lastname'])) == false)) throw new EmptyDataException("wrong_name_pattern");
        if(($validator->validatePassword($_SESSION['savedData']['password'])) == false) throw new EmptyDataException("wrong_password_pattern");
        if(($validator->validateUsername($_SESSION['savedData']['username'])) == false) throw new EmptyDataException("wrong_username_pattern");




        /**
         * Look if user with entered username already exists
         */
        if(!empty($userBiz->checkUserByUsername($_SESSION['savedData']['username']))) throw new UserExistsException("username_exists");


        /**
         * Look if user with entered e-mail already exists
         */
        if(!empty($userBiz->checkUserByEmail($_SESSION['savedData']['email']))) throw new UserExistsException("email_exists");


        $userImage = "default.jpg";


        if (isset($_FILES['userImage']) && (!empty($_FILES['userImage']['name'])))
        {

            $file = $_FILES['userImage'];

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

                        $file_destination = 'src/ProjectWhisky/presentation/userimages/' . $file_name_new;

                        if (move_uploaded_file($file_tmp, $file_destination))
                        {
                            $userImage = $file_name_new;
                        }
                    }
                    else
                    {
//                        $_SESSION['userDialogBlock'] = "Allowed file size is 2MB";
                        throw new ImageException('wrong_image_size');
                    }
                }
            }
            else
            {
                throw new ImageException('wrong_image');
            }
        }


        $newUser = $userBiz->addCPUser($_SESSION['savedData']['username'], $_SESSION['savedData']['password'], $_SESSION['savedData']['email'], $_SESSION['savedData']['firstname'], $_SESSION['savedData']['lastname'], $_SESSION['savedData']['admin'], $_SESSION['savedData']['blocked'], $userImage);

        if ($newUser == true)
        {
            $_SESSION['userDialogBlock'] = "success";
        }
        else
        {
            $_SESSION['userDialogBlock'] = "error";
        }
    }
    catch(ImageException $e)
    {
        $_SESSION['userDialogBlock'] = $e->getMessage();
    }
    catch(UserExistsException $e)
    {
        $_SESSION['userDialogBlock'] = $e->getMessage();
    }
    catch(EmptyDataException $e)
    {
        $_SESSION['userDialogBlock'] = $e->getMessage();
    }

    header("Location: cp_user_add.php?updated=1");
}    


$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
$twig = new Twig_Environment($loader);

$view = $twig->render("CP_user_add.twig", array("user" => $_SESSION['user'], "msg" => $_SESSION['userDialogBlock'], "savedData" => $_SESSION['savedData']));

print($view);


/**
 * Handling messages removal and appearance
 */
if (isset($_GET['updated']) && (empty($_SESSION['userDialogBlock'])))
{
    header("Location: cp_user_add.php");
}



if(isset($_GET['updated']) && ($_GET['updated'] == 1))
{
    $_SESSION['userDialogBlock'] = "";
//    $_SESSION['savedData'] = "";
}




ob_flush();