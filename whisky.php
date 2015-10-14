<?php
ob_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

use src\ProjectWhisky\business\WhiskyBusiness;
use src\ProjectWhisky\business\CommentBusiness;
use src\ProjectWhisky\business\BarrelBusiness;
use src\ProjectWhisky\business\UserBusiness;
use src\ProjectWhisky\business\DistilleryBusiness;
use src\ProjectWhisky\exceptions\CommentNotExistsException;
use src\ProjectWhisky\exceptions\FuckedUpException;
use Doctrine\Common\ClassLoader;


require_once("rolestarter.php"); // gives to user role = 0 on first visit of the website: role = 0 - guest



if ((isset($_GET['id'])) && (is_int((int)$_GET['id'])) && (!empty($_GET['id'])))
{
    /**
     * Connecting doctrine autoloader
     */
    require_once('Doctrine/Common/ClassLoader.php');
    $classLoader = new ClassLoader("src");
    $classLoader->register();

    require_once("lib/Twig/Autoloader.php");
    Twig_Autoloader::register();

    $whiskyBiz = new WhiskyBusiness();
    $whisky = $whiskyBiz->getWhisky($_GET["id"]);
    
    $barrelBiz = new BarrelBusiness();
    $barrel = $barrelBiz ->showBarrel($_GET["id"]);
    
    $distilleryBiz = new DistilleryBusiness();
    $distillery = $distilleryBiz ->getByWhisky($_GET["id"]);

    $commentBiz = new CommentBusiness();
    $userBiz = new UserBusiness();

    /**
     * Put comments data with user info into an array $participatedUsers
     */
    if (!empty($commentBiz->showComments($_GET["id"])))
    {
        foreach ($commentBiz->showComments($_GET["id"]) as $key => $comment)
        {
            $usersDataFromComments = $userBiz->getUserByComment($comment->getId());
            $participatedUsers[$key]['userId'] = $usersDataFromComments->getId();
            $participatedUsers[$key]['username'] = $usersDataFromComments->getUsername();
            $participatedUsers[$key]['imagePath'] = $usersDataFromComments->getImagePath();
            $participatedUsers[$key]['commentId'] = $comment->getId();
            $participatedUsers[$key]['comment'] = $comment->getComment();
            // Formatting time
            $participatedUsers[$key]['commentTime'] = new DateTime($comment->getCommentTime());
            $participatedUsers[$key]['commentTime'] = $participatedUsers[$key]['commentTime']->format('H:i');
            // Formatting date
            $participatedUsers[$key]['commentDate'] = new DateTime($comment->getCommentDate());
            $participatedUsers[$key]['commentDate'] = $participatedUsers[$key]['commentDate']->format('d/m/Y');

        }
    }
    else
    {
        $participatedUsers = array();
    }


    /**
     * Check if user actually authorized
     */
    if ((isset($_SESSION['user']['role']) && (($_SESSION['user']['role'] === 1) || ($_SESSION['user']['role'] === 2))))
    {
        /*
         * Insert new comment
         */
        if (isset($_POST['sendMsgBtn']))
        {
            // Message should contain > 5 chars
            if (strlen(trim(str_replace("&nbsp;","",strip_tags($_POST['editor1'])))) > 5)
            {
                echo str_replace("&nbsp;","",strip_tags($_POST['editor1']));

                $commentBiz->createComment($_GET['id'], $_SESSION['user']['id'], $_POST['editor1']);
                $_SESSION['messageBlock'] = "Comment added";
                $_SESSION['messageColor'] = "green";

                $pathToWhisky = "whisky.php?id=" . $_GET['id'] . "&action=1#message";

                header("Location: $pathToWhisky");
            }
            else
            {
                $_SESSION['messageBlock'] = "You need to write more to place a comment";
                $_SESSION['messageColor'] = "yellow";

                $pathToWhisky = "whisky.php?id=" . $_GET['id'] . "&action=1#message";
                header("Location: $pathToWhisky");
            }

        }

        /**
         * Remove comment
         */
        if (isset($_POST['deleteCommentBtn']))
        {
            try
            {
                $commentControl = $commentBiz->controleCommentExistence($_POST['commentId']);

                if((empty($commentControl))) throw new CommentNotExistsException();

                /**
                 * Admins can remove all messages and Users can remove their messages only
                 * If in session stored userId doesn't match with the userId dedicated to spcific commentId show an error
                 */
                if(($_SESSION['user']['role'] !== 2) && ($commentControl['userId'] !== $_SESSION['user']['id'])) throw new CommentNotExistsException();

                if(!$commentBiz->removeComment($_POST['commentId'])) throw new FuckedUpException();

                $_SESSION['messageBlock'] = "Comment deleted";
                $_SESSION['messageColor'] = "green";

                $pathToWhisky = "whisky.php?id=" . $_GET['id'] . "&action=1#message";
                header("Location: $pathToWhisky");

            }
            catch(CommentNotExistsException $e)
            {
//            $_SESSION['whiskyDialog'] = "You have not enough permissions to do that";
                $_SESSION['messageBlock'] = "You have not enough permissions...";
                $_SESSION['messageColor'] = "red";

                $pathToWhisky = "whisky.php?id=" . $_GET['id'] . "&action=1#message";
                header("Location: $pathToWhisky");
            }
            catch(FuckedUpException $e)
            {
                $_SESSION['messageBlock'] = "Something is wrong";
                $_SESSION['messageColor'] = "yellow";

                $pathToWhisky = "whisky.php?id=" . $_GET['id'] . "&action=1#message";
                header("Location: $pathToWhisky");
            }

        }
    }



    if (!isset($_SESSION['messageBlock']))
    {
        $_SESSION['messageBlock'] = "";
        $_SESSION['messageColor'] = "";
    }







    /**
     * Send to TWIG
     */
    $loader = new Twig_Loader_Filesystem("src/ProjectWhisky/presentation");
    $twig = new Twig_Environment($loader);

    $view = $twig->render("whisky_page.twig", array("user" => $_SESSION['user'], "messageBlock" => $_SESSION['messageBlock'], "messageColor" => $_SESSION['messageColor'], "whisky" => $whisky, "participatedUsers" => $participatedUsers,
                             "barrel" => $barrel['type'], "region" => $distillery['region'], "distilleryName" => $distillery['distilleriesname']));

    print($view);

}
else
{
    header("Location: index.php");
}


/**
 * If "action" == 1 && message block is empty, show whisky page
 */
if ((isset($_GET['action'])) && ($_GET['action'] == 1) && (empty($_SESSION['messageBlock'])))
{
    $pathToWhisky = "whisky.php?id=" . $_GET['id'];
    header("Location: $pathToWhisky");
}

/**
 * Remove "messageBlock" contents if "action" == 1 and "messageBlock" isn't empty
 */
if ((isset($_GET['action'])) && ($_GET['action'] == 1) && (!empty($_SESSION['messageBlock'])))
{
    $_SESSION['messageBlock'] = "";
    $_SESSION['messageColor'] = "";
}





ob_flush();
