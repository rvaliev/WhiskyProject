<?php

/**
 * This file must be included at the top of every controller!
 * Responsible for assigning role for guest
 *
 */

/**
 * If $_SESSION['user'] isn't initiated, create one and put role = 0
 */
if(!isset($_SESSION['user']))
{
    $_SESSION['user']['role'] = 0; // guest
}