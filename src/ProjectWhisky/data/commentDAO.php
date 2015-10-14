<?php

namespace src\ProjectWhisky\data;
use src\ProjectWhisky\data\DBConnect;
use src\ProjectWhisky\entities\Comment;
use src\ProjectWhisky\entities\User;
use PDO;
use Exception;


class CommentDAO
{
    private $result;
    private $handler;
    private $sql;
    private $query;
    private $list;


    /**
     * Defining constructor
     */
    public function __construct()
    {
    }

    /**
     * Method which creates a DB connection
     */
    private function connectToDB()
    {
        $this->handler = new DBConnect();
        $this->handler = $this->handler->startConnection();
    }


    public function getAllComments()
    {
        self::connectToDB(); /* Using DB connection */
        $this->sql = "SELECT * FROM comments";

        try
        {
            $this->query = $this->handler->query($this->sql);
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);
            
             
             /**
             * Closing DB connection
             */
            $this->query->closeCursor();
            $this->handler = null;

            foreach ($this->result as $row)
            {
                $this->list[] = new Comment($row['id'], $row['whisky_id'], $row['user_id'], $row['comment'], $row['time'], $row['date']);
            }

            return $this->list;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }

    /**
     * Get comment by whisky id
     */
    public function getCommentByWhisky($whiskyId)
    {
        self::connectToDB();
        $this->sql = "SELECT comments.id AS commentsid, whisky_id, user_id, comment, time, date, username, image_path
        FROM comments, users
        WHERE whisky_id = :whiskyId AND user_id = users.id";

        try
        {
            $this->query = $this->handler->prepare($this->sql);
            $this->query->execute(array('whiskyId'=> $whiskyId));
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);

            $this->query->closeCursor();
            $this->handler = null;

            foreach ($this->result as $row)
            {
                $this->list[] = new Comment($row['commentsid'], $row['whisky_id'], $row['user_id'], $row['username'], $row['comment'], $row['time'], $row['date'], $row['image_path']  );
            }
            return $this->list;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }


    /**
     * Insert new comment into whisky page
     */
    public function insertNewComment($whiskyid, $userId, $comment)
    {
        self::connectToDB();

        $this->sql = "INSERT INTO comments (whisky_id, user_id, comment, time, date) VALUES (?, ?, ?, NOW(), NOW())";

        try
        {
            $this->query = $this->handler->prepare($this->sql);
            $this->query->execute(array($whiskyid, $userId, $comment));

            $this->query->closeCursor();
            $this->handler = null;

            return true;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }


    /**
     * Delete comment
     */
    public function deleteComment($commentId)
    {
        self::connectToDB();

        $this->sql = "DELETE FROM comments WHERE id = ?";

        try
        {
            $this->query = $this->handler->prepare($this->sql);
            $this->query->execute(array($commentId));

            $this->query->closeCursor();
            $this->handler = null;

            return true;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }


    /**
     * Check if comment exists before deletion
     */
    public function checkCommentExistence($commentId)
    {
        self::connectToDB();
        $this->sql = "SELECT id as commentId, user_id as userId FROM comments WHERE id = ?";

        try
        {
            $this->query = $this->handler->prepare($this->sql);
            $this->query->execute(array($commentId));
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);

            $this->query->closeCursor();
            $this->handler = null;

            return $this->result;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }

}