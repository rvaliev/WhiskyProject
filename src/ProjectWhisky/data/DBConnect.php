<?php
namespace src\ProjectWhisky\data;

use PDO;
use PDOException;

/**
 * Class DBConnect
 * @package src\ProjectWhisky\data
 * Establishes the database connection
 */

class DBConnect
{
    private $handler;

    public function startConnection()
    {
        try
        {
            $this->handler = new PDO('mysql:host=localhost;dbname=whiskyclub;charset=utf8','user','password',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

            $this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->handler;
        }
        catch (PDOException $e)
        {
//            echo $e->getMessage();
            echo "Problem with DB";
            die();
        }
    }
}


