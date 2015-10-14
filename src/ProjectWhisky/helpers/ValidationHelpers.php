<?php

namespace src\ProjectWhisky\helpers;
use src\ProjectWhisky\exceptions\WrongDataException;


class ValidationHelpers
{
    private $userDAO;
    private $list;
    private $email;
    private $userId;
    private $name;
    private $userName;
    private $password;
    private $passwordHash;


    /**
     * Hash passwords
     */
    public function hashPassword($passwordToHash, $rounds = 10)
    {
        $crypt_options = array('cost' => $rounds);
        $hash = password_hash($passwordToHash, PASSWORD_BCRYPT, $crypt_options);
        return $hash;
    }

    /**
     * Checking whether entered password is correct or not
     */
    public function checkPassword($passwordHash, $passwordEntered)
    {
        if(password_verify($passwordEntered, $passwordHash) == true)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    /**
     * E-mail validation
     * E-mail must have the following pattern: mail@mail.com
     */
    public function validateEmail($email)
    {
        return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    }

    /**
     * Password validation
     * Password must contain:
     * Minimum 8 chatacters
     * Minimum 1 capital letter
     * Minimum 1 number
     */
    public function validatePassword($password)
    {
        $this->password = trim(($password));
        return preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $this->password);
    }


    /**
     * Firstname or lastname validation
     * Minimum symbols: 8 (you need to check if namefield is NOT empty)
     * Maximum symbols = 30
     * All romain alphabetic letters are allowed
     * Also this symbols are allowed: '`-éèçàëêe and spaces
     */
    public function validateName($name)
    {
        $this->name = trim(($name));
        return preg_match("/^([A-Za-z '`-éèçàëê]{2,30})$/", $this->name);
    }

    /**
     * Username validation
     * Username can contain alphanumeric characters only
     * Minimum symbols: 4
     * Maximum symbols: 15
     */
    public function validateUsername($userName)
    {
        $this->userName = trim(($userName));
        return preg_match("/^([a-zA-Z0-9]{4,15})$/", $this->userName);
    }



    /**
     * Validate integers
     */


}