<?php

namespace src\ProjectWhisky\entities;

class Barrel
{
    private $id;
    private $type;
    
    // CONSTRUCTOR
    public function __construct($id, $type)
    {
        $this->id = $id;
        $this->type = $type;
    }
    
    // ACCESSORS (Getters)
    
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }
    
    // TRANSFORMERS (Setters)
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}
