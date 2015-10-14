<?php

namespace src\ProjectWhisky\entities;

Class Comment
{
    private $id;
    private $whiskyId;
    private $userId;
    private $username;
    private $comment;
    private $commentTime;
    private $commentDate;

    // CONSTRUCTOR
    public function __construct($id, $whiskyId, $userId, $username, $comment, $commentTime, $commentDate)
    {
        $this->id = $id;
        $this->whiskyId = $whiskyId;
        $this->userId = $userId;
        $this->username = $username;
        $this->comment = $comment;
        $this->commentTime = $commentTime;
        $this->commentDate = $commentDate;
    }
    
    // ACCESSORS (Getters)
    
    public function getId()
    {
        return $this->id;
    }

    public function getWhiskyId()
    {
        return $this->whiskyId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
    public function getUsername()
    {
        return $this->username;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getCommentTime()
    {
        return $this->commentTime;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }
    
    // TRANSFORMERS (Setters)
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setWhiskyId($whiskyId)
    {
        $this->whiskyId = $whiskyId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setUsername($username)
    {
        $this->username=$username;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setCommentTime($commentTime)
    {
        $this->commentTime = $commentTime;
    }

    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }
}