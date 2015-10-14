<?php


if (!isset($_SESSION['user']['id']))
{
    header("Location: index.php");
}

if ($_SESSION['user']['role'] != 2)
{
    header("Location: index.php");
}