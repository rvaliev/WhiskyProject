<?php

session_start();


/**
 * Log out user
 */
if(isset($_GET['logout']) && ($_GET['logout'] == true))
{
    $_SESSION['user'] = array();
    session_destroy();
    header("Location: index.php");

}
