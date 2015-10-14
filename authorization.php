<?php

ob_start();

use src\ProjectWhisky\business\UserBusiness;
use src\ProjectWhisky\business\AuthorizationBusiness;
use src\ProjectWhisky\helpers\ValidationHelpers;
use src\ProjectWhisky\exceptions\WrongDataException;
use src\ProjectWhisky\exceptions\EmptyDataException;
use src\ProjectWhisky\exceptions\UserBlockedException;
use src\ProjectWhisky\exceptions\WrongPasswordPatternException;
use src\ProjectWhisky\exceptions\WrongEmailPatternException;
use Doctrine\Common\ClassLoader;

session_start();



/**
 * Check entered e-mail and password when "log in" button has been pressed
 */
if(isset($_POST['emailField']))
{
    $email = $_POST['emailField'];
    $password = $_POST['passField'];

    /**
     * Connecting doctrine autoloader
     */
    require_once'Doctrine/Common/ClassLoader.php';
    $classLoader = new ClassLoader("src");
    $classLoader->register();

    try
    {
        /**
         * Throw error if email and password fields are empty
         */
        if (empty($email) || empty($password)) throw new EmptyDataException();

        $validator = new ValidationHelpers(); // helper validation class

        /**
         * Email validation
         */
        $emailValidated = $validator->validateEmail($_POST['emailField']);
        if(!$emailValidated) throw new WrongEmailPatternException();

        /**
         * Password validation
         */
        $passwordValidated = $validator->validatePassword($_POST['passField']);
        if(!$passwordValidated) throw new WrongPasswordPatternException();

        /**
         * Throw error if email and password contain wrong characters
         */
        if(empty($email) && empty($password)) throw new WrongDataException();


        /**
         * Authorize user
         * Throw error if email-password combination is wrong (Exception comes from AuthorizationBusiness)
         */
        $authorization = new AuthorizationBusiness();
        $user = $authorization->authorize($email, $password);


        /*
         * Check if user is blocked
         */
        if($user->getBlocked() == 1) throw new UserBlockedException();


        /*
         * Check if user is admin
         */
        if($user->getAdmin() == 1)
        {
            $_SESSION['user']['role'] = 2; // Store in session that user is an admin; 2 = admin
        }
        else
        {
            $_SESSION['user']['role'] = 1; // Store in session that user is NOT an admin; 1 = regular user
        }

        $_SESSION['user']['id'] = $user->getId(); //Store userIn into session
        $_SESSION['user']['firstname'] = $user->getFirstname(); // Store user firstname into session
        $_SESSION['user']['username'] = $user->getUsername();


        echo "<span class='success'>You're in</span>";
?>

        <script>
            setTimeout(function(){
                location.reload();
            }, 2000);
        </script>
        
<?php

    }
    catch (EmptyDataException $e)
    {
        echo "<span class='error_message'>E-mail and password fields can't be empty</span>";
    }
    catch (WrongDataException $e)
    {
        echo "<span class='error_message'>Wrong e-mail and password combination.</span>";
    }
    catch (UserBlockedException $e)
    {
        echo "<span class='error_message'>Your account has been blocked.</span>";
    }
    catch (WrongPasswordPatternException $e)
    {
        echo "<span class='error_message'>Password must contain min. 8 characters, min. 1 capital letter and min. 1 number.</span>";
    }
    catch (WrongEmailPatternException $e)
    {
        echo "<span class='error_message'>E-mail must have this pattern: mail@mail.com</span>";
    }

}
else
{
    header('Location: index.php');
}

ob_flush();
