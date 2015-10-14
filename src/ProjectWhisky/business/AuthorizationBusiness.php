<?php

namespace src\ProjectWhisky\business;
use src\ProjectWhisky\data\UserDAO;
use src\ProjectWhisky\helpers\ValidationHelpers;
use src\ProjectWhisky\exceptions\WrongDataException;


class AuthorizationBusiness extends ValidationHelpers
{
    private $userDAO;
    private $list;
    private $email;
    private $userId;
    private $password;
    private $passwordHash;

    /**
     * Login authorization
     */
    public function authorize($email, $password)
    {
        $this->email = $email;
        $this->password = $password;

        /**
         * Chech if user exists in DB
         */
        $this->userDAO = new UserDAO();
        $this->list = $this->userDAO->findUserByEmail($this->email);

        /**
         * Report exception if user doesn't exit
         */
        if (!isset($this->list)) throw new WrongDataException();


        /**
         * Get hashed password from DB and check if by user inserted password matches with hashed one.
         */
        $this->passwordHash = $this->list->getPassword();
        self::checkPassword($this->passwordHash, $this->password);  // uses ValidationHelpers class

        return $this->list;

    }


}