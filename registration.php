<?php

ob_start();

use src\ProjectWhisky\business\UserBusiness;
use src\ProjectWhisky\helpers\ValidationHelpers;
use src\ProjectWhisky\exceptions\WrongDataException;
use src\ProjectWhisky\exceptions\EmptyDataException;
use src\ProjectWhisky\exceptions\PasswordsDontMatchException;
use src\ProjectWhisky\exceptions\WrongEmailFormException;
use src\ProjectWhisky\exceptions\UsernameExistsException;
use src\ProjectWhisky\exceptions\EmailExistsException;
use src\ProjectWhisky\exceptions\WrongPasswordPatternException;
use src\ProjectWhisky\exceptions\WrongEmailPatternException;
use src\ProjectWhisky\exceptions\WrongNamePatternException;
use src\ProjectWhisky\exceptions\WrongUserNamePatternException;

use Doctrine\Common\ClassLoader;






/**
 * Check entered e-mail and password when "log in" button has been pressed
 */
if(isset($_POST['firstname']))
{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rpassword = $_POST['rpassword'];

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
        if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($password) || empty($rpassword)) throw new EmptyDataException();

        $validator = new ValidationHelpers();

        $firstnameValidated = $validator->validateName($firstname);
        $lastnameValidated = $validator->validateName($lastname);
        $emailValidated = $validator->validateEmail($email);
        $usernameValidated = $validator->validateUsername($username);
        $passwordValidated = $validator->validatePassword($password);
        $rpasswordValidated = $validator->validatePassword($rpassword);


        if(!$firstnameValidated) throw new WrongNamePatternException(); // validate firstname
        if(!$lastnameValidated) throw new WrongNamePatternException(); // validate lastname
        if(!$emailValidated) throw new WrongEmailPatternException(); // validate e-mail
        if(!$usernameValidated) throw new WrongUserNamePatternException(); // validate username
        if(!$passwordValidated) throw new WrongPasswordPatternException(); // validate pass
        if(!$rpasswordValidated) throw new WrongPasswordPatternException(); // validate repeated pass

        /**
         * Check whether passwords are the same
         */
        if($password !== $rpassword) throw new PasswordsDontMatchException();


        $user = new UserBusiness();
        /**
         * Look if user with entered e-mail already exists
         */
        if(!empty($user->checkUserByEmail($email))) throw new EmailExistsException();
        /**
         * Look if user with entered username already exists
         */
        if(!empty($user->checkUserByUsername($username))) throw new UsernameExistsException();


        /**
         * Create user
         */
        $user->createNewUser($username,$password,$email,$firstname,$lastname);

        echo "<span class='success'>Registration complete! You can log in now.</span>";


?>
        <script>
//            jQuery("#register_form").fadeOut(10);
        </script>
<?php







    }
    catch (EmptyDataException $e)
    {
        echo "Please fill in all fields to become a whiskyman!";
    }
    catch (WrongDataException $e)
    {
        echo "Wrong e-mail and password combination.";
    }
    catch (PasswordsDontMatchException $e)
    {
        echo "Passwords must be the same";
    }
    catch(WrongEmailFormException $e)
    {
        echo "Wrong e-mail pattern";
    }
    catch(UsernameExistsException $e)
    {
        echo "Username already exists - choose another username.";
    }
    catch(EmailExistsException $e)
    {
        echo "User with this e-mail already exists - choose another e-mail.";
    }
    catch(WrongNamePatternException $e)
    {
        echo "Wrong name pattern - use only alphabetic letters, or this symbols: '`-éèçàëêe and spaces";
    }
    catch(WrongEmailPatternException $e)
    {
        echo "E-mail must have this pattern: mail@mail.com";
    }
    catch(WrongUserNamePatternException $e)
    {
        echo "Username can contain alphanumeric symbols only, and should contain from 4 to 15 characters";
    }
    catch(WrongPasswordPatternException $e)
    {
        echo "Password must contain min. 8 characters, min. 1 capital letter and min. 1 number.";
    }

}
else
{
    header("Location: index.php");
}

ob_flush();






