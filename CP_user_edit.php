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


if ((!isset($_GET["id"])) || (empty($_GET["id"])) || (!is_numeric($_GET["id"])))
{
    header("Location: cp_user.php");
}

$userId = $_GET["id"];

//GET userdata by id
$userBiz = new UserBusiness;
$userdata = $userBiz->getUserbyId($_GET["id"]);

if (!isset($_SESSION['userDialogBlock']))
{
    $_SESSION['userDialogBlock'] = "";
}

if (isset($_POST['userUsername']))
{
    try
    {
        //form POST data
        $userId = $_GET["id"];
        $username = $_POST['userUsername'];

        if (!empty($_POST['userPassword']))
        {
            $newPass = true;
            $password = $_POST['userPassword'];
        }
        else
        {
            $newPass = false;
            $password = $userdata->getPassword();
        }

        $email = $_POST['userEmail'];
        $firstname = $_POST['userFirstName'];
        $lastname = $_POST['userLastName'];


        if(empty($username) || empty($email) || empty($firstname) || empty($lastname))
        {
            throw new EmptyDataException("missing");
        }


        $admin = false;
        if(isset($_POST['userAdmin'])){
            $admin = true;
        }

        $blocked = false;
        if(isset($_POST['userBlocked'])){
            $blocked = true;
        }

        /**
         * Get current image name
         */
        $currentUserImagePath = $userdata->getImagePath();



        /**
         * Validate data
         */
        $validator = new ValidationHelpers();
        if(($validator->validateEmail($email)) == false) throw new EmptyDataException("wrong_email_pattern");
        if(($validator->validateName($firstname) == false) || ($validator->validateName($lastname) == false)) throw new EmptyDataException("wrong_name_pattern");
        if(($validator->validatePassword($password)) == false) throw new EmptyDataException("wrong_password_pattern");
        if(($validator->validateUsername($username)) == false) throw new EmptyDataException("wrong_username_pattern");


        if($userdata->getUsername() != $username)
        {
            /**
             * Look if user with entered username already exists
             */
            if(!empty($userBiz->checkUserByUsername($username))) throw new UserExistsException("username_exists");
        }

        if($userdata->getEmail() != $email)
        {
            /**
             * Look if user with entered e-mail already exists
             */
            if(!empty($userBiz->checkUserByEmail($email))) throw new UserExistsException("email_exists");
        }





        /**
         * Upload image
         */
        if (isset($_FILES['user_image']) && (!empty($_FILES['user_image']['name'])))
        {

            $file = $_FILES['user_image'];

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
                            if($currentUserImagePath !== "default.jpg")
                            {
                                $toRemoveImage = "src/ProjectWhisky/presentation/userimages/" . $currentUserImagePath;
                                unlink($toRemoveImage);
                            }

                            $currentUserImagePath = $file_name_new;

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

        $updatedUserProfile = $userBiz->updateUserById($userId, $username, $password, $email, $firstname, $lastname, $admin, $blocked, $currentUserImagePath, $newPass);

        if ($updatedUserProfile)
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


    $path = "cp_user_edit.php?id=" . $userId . "&updated=1";
    header("Location: $path");
}





$loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
$twig = new Twig_Environment($loader);

$view = $twig->render("CP_user_edit.twig", array("user" => $_SESSION['user'], "userdata" => $userdata, "msg" => $_SESSION['userDialogBlock'] ));

print($view);



/**
 * Handling messages removal and appearance
 */
if (isset($_GET['updated']) && (empty($_SESSION['userDialogBlock'])))
{
    $path = "cp_user_edit.php?id=" . $userId;
    header("Location: $path");
}



if(isset($_GET['updated']) && ($_GET['updated'] == 1))
{
    $_SESSION['userDialogBlock'] = "";
}




ob_flush();