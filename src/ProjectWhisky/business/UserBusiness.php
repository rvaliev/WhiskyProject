<?php

namespace src\ProjectWhisky\business;
use src\ProjectWhisky\data\UserDAO;
use src\ProjectWhisky\helpers\ValidationHelpers;
use src\ProjectWhisky\exceptions\WrongDataException;



class UserBusiness extends ValidationHelpers
{
    private $userDAO;
    private $list;

    /**
     * Getting all information from all users
     */
    public function getAllUsers()
    {
        $this->userDAO = new UserDAO();
        $this->list = $this->userDAO->getAll();
        return $this->list;
    }


    /**
     * Searching user by email
     */
    public function searchUserByEmail($email)
    {
        $this->userDAO = new UserDAO();
        $this->list = $this->userDAO->findUserByEmail($email);

        if(!isset($this->list)) throw new WrongDataException();
        return $this->list;

    }


    /**
     * Creating new user
     */
    public function createNewUser($username, $password, $email, $firstname, $lastname)
    {
        $password = self::hashPassword($password); // using ValidationHelpers class
        $this->userDAO = new UserDAO();
        $this->list = $this->userDAO->createUser($username, $password, $email, $firstname, $lastname);

        return $this->list;
    }



    /**
     * Checking user by username
     */
    public function checkUserByUsername($username)
    {
        $this->userDAO = new UserDAO();
        $this->list = $this->userDAO->lookForUserByUsername($username);

        return $this->list;
    }


    /**
     * Checking user by email
     */
    public function checkUserByEmail($email)
    {
        $this->userDAO = new UserDAO();
        $this->list = $this->userDAO->lookForUserByEmail($email);

        return $this->list;
    }
    public function getUserByComment($commentId)
    {
        $this->userDAO = new UserDAO();
        $this->list = $this->userDAO->getUserByComment($commentId);
        
        return $this->list;
    }

    public function getUserbyId($userId)
    {
        $userDAO = new UserDAO();
        $user = $userDAO->getUserById($userId);
        return $user;
    }
    
    public function updateUserById($userId, $username, $password, $email, $firstname, $lastname, $admin, $blocked, $userImagePath, $newPass)
    {
        if ($newPass == true)
        {
            $password = self::hashPassword($password); // using ValidationHelpers class
        }

        $userDAO = new UserDAO();
        $user = $userDAO->updateUserbyId($userId, $username, $password, $email, $firstname, $lastname, $admin, $blocked, $userImagePath);
        return $user;
    }
    public function addCPUser($username, $password, $email, $firstname, $lastname, $admin, $blocked, $imagePath)
    {
        $password = self::hashPassword($password); // using ValidationHelpers class
        $userDAO = new UserDAO();
        return $userDAO -> createCPUser($username, $password, $email, $firstname, $lastname, $admin, $blocked, $imagePath);
    }
	

	//search for users with a certain string in their username
	public function getUsersByUsername($username)
	{
		$userDAO = new UserDAO();
		$userlist = $userDAO -> getUsersByUsername($username);
		
		return $userlist;
	}
	
	
	




}