<?php

namespace src\ProjectWhisky\data;
use src\ProjectWhisky\data\DBConnect;
use src\ProjectWhisky\entities\Distillery;
use PDO;
use Exception;


class DistilleryDAO
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

    public function getAll()
    {
        self::connectToDB(); /* Using DB connection */
        $this->sql = "SELECT * FROM distilleries";

        try
        {
            $this->query = $this->handler->query($this->sql);
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);

            $this->query->closeCursor();
            $this->handler = null;

            foreach ($this->result as $row)
            {
                $this->list[] = new Distillery($row['id'], $row['name'], $row['address'], $row['city'], $row['country'], $row['region']);
            }

            return $this->list;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }


    public function getById($id)
    {
        self::connectToDB();
        $this->sql = "SELECT * FROM distilleries WHERE id = :id";

        try
        {
            $this->query = $this->handler->prepare($this->sql);
            $this->query->execute(array('id'=> $id));
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);

            $this->query->closeCursor();
            $this->handler = null;

            foreach ($this->result as $row)
            {
               $this->list = new Distillery($row['id'], $row['name'], $row['address'], $row['city'], $row['country'], $row['region']);
            }
            return $this->list;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }
    
    public function getDistilleryByWhiskyId($whiskyId)
    {
        self::connectToDB();
        $this->sql = "SELECT region, distilleries.name as distilleriesname, whiskies.id, distilleries.id
                    FROM distilleries, whiskies
                    WHERE distilleries.id = distillery_id and whiskies.id = :whiskyId"  ;

        try
        {
            $this->query = $this->handler->prepare($this->sql);
            $this->query->execute(array('whiskyId'=> $whiskyId));
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);

            $this->query->closeCursor();
            $this->handler = null;

            return $this->result[0];
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }
    
    public function getRegions()
    {
        self::connectToDB(); /* Using DB connection */
        $this->sql = "SELECT *
        FROM distilleries 
        GROUP BY region";

        try
        {
            $this->query = $this->handler->query($this->sql);
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);

            $this->query->closeCursor();
            $this->handler = null;

            foreach ($this->result as $row)
            {
                $this->list[] = new Distillery($row['id'], $row['name'], $row['address'], $row['city'], $row['country'], $row['region']);
            }

            return $this->list;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }
    
    public function addDistillery($name, $address, $city, $country, $region)
    {
        self::connectToDB();
            $this->sql = "insert into distilleries(name, address, city, country, region) values('$name', '$address', '$city', '$country', '$region')" ;

            try
            {
                $this->query = $this->handler->prepare($this->sql);
                $this->query->execute();

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
    
    public function editDistillery($id, $name, $address, $city, $country, $region)
    {
        self::connectToDB();
           $this->sql = "update distilleries set name='$name', address='$address', city='$city', country='$country', region='$region' where id = $id";

           try
           {
               $this->query = $this->handler->prepare($this->sql);
               $this->query->execute();

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
    //search for distilleries with a certain string in their name
    public function getDistilleriesByName($name)
    {
        self::connectToDB(); /* Using DB connection */

        $this->sql = "SELECT * 
                    FROM distilleries
                    WHERE distilleries.name LIKE ?";

        try
        {
            $this->query = $this->handler->prepare($this->sql);
            
            $this->query->execute(array('%' . $name . '%'));
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);
            $this->query->closeCursor();
            $this->handler = null;

           foreach ($this->result as $row)
            {
                $this->list[] = new Distillery($row['id'], $row['name'], $row['address'], $row['city'], $row['country'], $row['region']);
            }
            return $this->list;
        }
        catch (Exception $e)
        {
            echo "Error: query failure";
            return false;
        }
    }

}