<?php
ob_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * User profile controller
 */

/**
 * IMPORTANT: add following things in every controller:
 * session_start()
 * require_once("rolestarter.php");
 * "user" => $_SESSION['user'] needs to be sent to Twig
 */

session_start();


use src\ProjectWhisky\business\ProfileBusiness;
use src\ProjectWhisky\exceptions\WrongDataException;
use src\ProjectWhisky\exceptions\PasswordsDontMatchException;
use src\ProjectWhisky\exceptions\FuckedUpException;
use src\ProjectWhisky\exceptions\EmptyDataException;
use src\ProjectWhisky\exceptions\ImageException;
use src\ProjectWhisky\exceptions\PasswordException;
use Doctrine\Common\ClassLoader;

require_once("rolestarter.php"); // gives to user role = 0 on first visit of the website: role = 0 - guest


if (isset($_SESSION['user']['id']) && (is_int((int)$_SESSION['user']['id'])))
{
    /**
     * Dialog variable which stores and shows errors or success messages
     */
    if (!isset($_SESSION['dialogBlock']))
    {
        $_SESSION['dialogBlock'] = "";
    }





    $userId = $_SESSION['user']['id'];

    /**
     * Connecting doctrine autoloader
     */
    require_once'Doctrine/Common/ClassLoader.php';
    $classLoader = new ClassLoader("src");
    $classLoader->register();

    require_once("lib/Twig/Autoloader.php");
    Twig_Autoloader::register();

    /**
     * Creating new profile object
     */
    $profile = new ProfileBusiness();

    /**
     * Get user data by user id: firstname, lastname, e-mail, user image
     */
    $userData = $profile->getUserDataByUserId($userId); // sended to twig on the  end




    /**
     * Perform form workout
     */
    if (isset($_POST['userFirstName']))
    {
        try
        {
            if((empty($_POST['userFirstName'])) || (empty($_POST['userLastName'])) || empty($_POST['userEmail'])) throw new EmptyDataException("missing");

            $firstname = $_POST['userFirstName'];
            $lastname = $_POST['userLastName'];
            $email = $_POST['userEmail'];
            /**
             * Perform updating fields
             */
            if ($profile->updateUserDataByUserId($userId, $firstname, $lastname, $email) !== true) throw new FuckedUpException("error");

            $_SESSION['dialogBlock'] = "success";
            $_SESSION['reload'] = 1;



        }
        catch (EmptyDataException $e)
        {
            $_SESSION['dialogBlock'] = $e->getMessage();
        }
        catch (FuckedUpException $e)
        {
            $_SESSION['dialogBlock'] = $e->getMessage();
        }


        header('Location: profile.php?updated=1');

    }




    /*
     * A defined function which renames image path
     * Object $profile required to be given to this function
     */
    function updateImagePathInDB($userId, $newImagePath, $profile)
    {
       return $profile->updateUserImagePath($userId, $newImagePath);
    }


    /**
     * Upload image
     */
    if (isset($_FILES['userImage']) && !empty($_FILES['userImage']['name']))
    {
        try
        {
            $file = $_FILES['userImage'];

            /**
             * File properties
             */
            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];

            /**
             * Work out the file extension
             * If move_uploaded_file gives permission error, 'cd' to 'userimages' folder and give it wright permissions: 'chmod 0777 userimages' (both machines)
             */
            $fileExt = explode('.', $fileName);
            $fileExt = strtolower(end($fileExt));

            /**
             * Define allowed file extensions
             */
            $allowed = array('png', 'jpg', 'jpeg', 'gif');
            if(!in_array($fileExt, $allowed)) throw new ImageException("imageExtension"); // check if file has allowed extension
            
            if($fileError !== 0) throw new ImageException("imageError"); // check if there is no overall error during file upload

            if($fileSize > 1000000) throw new ImageException("imageSize"); // check if file > 1MB

            $fileNameNew = uniqid('', true) . '.' . $fileExt; // uniqid - creates unique id based on current timestamp in microseconds
            $file_destination = 'src/ProjectWhisky/presentation/userimages/' . $fileNameNew;

            if(!move_uploaded_file($fileTmp, $file_destination)) throw new ImageException("uploadProblem"); // give error if file move is failed (ex. if folder rights aren't 0777)

            $newImagePath = $fileNameNew;
            /**
             * Calling defined function and giving parameters. $profile is an object
             */
            if(!updateImagePathInDB($userId, $newImagePath, $profile)) throw new ImageException("pathError"); // give error if there's problem with updating image path in DB


            $_SESSION['dialogBlock'] = "success";

            /**
             * Remove old image if it's not 'default.jpg'
             */
            if($userData['image_path'] !== "default.jpg")
            {
                $toRemoveImage = "src/ProjectWhisky/presentation/userimages/" . $userData['image_path'];
                unlink($toRemoveImage);
            }
        }
        catch(ImageException $e)
        {
            $_SESSION['dialogBlock'] = $e->getMessage();
        }
    }


    /**
     * Remove image
     */
    if (isset($_POST['removeProfileImageBtn']))
    {
        try
        {
            /**
             * if user removes his picture, a default.jpg will be added to his profile
             */
            $newImagePath = "default.jpg";

            /**
             * Change image name in DB
             */
            if(!updateImagePathInDB($userId, $newImagePath, $profile)) throw new ImageException("pathError"); // give error if there's problem with updating image path in DB

            $toRemoveImage = "src/ProjectWhisky/presentation/userimages/" . $userData['image_path'];
            unlink($toRemoveImage);
            $_SESSION['dialogBlock'] = "success";
        }
        catch(ImageException $e)
        {
            $_SESSION['dialogBlock'] = $e->getMessage();
        }

        header('Location: profile.php?updated=1');
    }



    /**
     * Perform password change only if user presses "Change password" button on profile page
     */
    if ((!empty($_POST['userOldPassword'])))
    {
        try
        {
            $oldPassword = $_POST['userOldPassword'];
            $newPassword = $_POST['userNewPassword'];
            $newPasswordRepeat = $_POST['userNewPasswordRepeat'];

            /**
             * Check if entered password matches the old one
             */
            if(($profile->checkOldPassword($userId, $oldPassword)) == false) throw new PasswordException("wrongOldPassword");

            /**
             * Check if passwords are matching
             */
            if ($_POST['userNewPassword'] !== $_POST['userNewPasswordRepeat']) throw new PasswordException("passwordsNotSame");

            /**
             * Validate password pattern
             */
            if(($profile->validatePassword($_POST['userNewPassword'])) == false) throw new PasswordException("passwordNotValid");

            /**
             * Update old password
             */
            if (!$profile->updateNewPassword($userId, $newPassword)) throw new PasswordException("error");

            $_SESSION['dialogBlock'] = "success";
        }
        catch (PasswordException $e)
        {
            $_SESSION['dialogBlock'] = $e->getMessage();
        }
    }



    if (!isset($fileName))
    {
        $fileName = "Change profile image";
    }
    /**
     * Load Twig template
     */
    $loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
    $twig = new Twig_Environment($loader);
    $view = $twig->render("profile.twig", array("user" => $_SESSION['user'], "userData" => $userData, "msg" => $_SESSION['dialogBlock'], 'imageName' => $fileName));

    print($view);


    /**
     * Handling messages removal and appearance
     */
    if (isset($_GET['updated']) && (empty($_SESSION['dialogBlock'])))
    {
        header('Location: profile.php');
    }


    if(isset($_GET['updated']) && ($_GET['updated'] == 1))
    {
        $_SESSION['dialogBlock'] = "";
        unset($_SESSION['reload']);
    }





}
else
{
    header("Location: index.php");
}

echo "<pre>";
print_r($_SESSION['aaa']);
echo "</pre>";

ob_flush();


