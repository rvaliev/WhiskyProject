<?php

namespace src\ProjectWhisky\entities;

Class Distillery
{
    private $id;
    private $name;
    private $address;
    private $city;
    private $country;
    private $region;
    
    // CONSTRUCTOR
    public function __construct($id, $name, $address, $city, $country, $region)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->region = $region;
    }
    
    
    // ACCESSORS (Getters)
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getaddress()
    {
        return $this->address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getRegion()
    {
        return $this->region;
    }
    
    // TRANSFORMERS (Setters)
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setaddress($address)
    {
        $this->address = $address;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function setRegion($region)
    {
        $this->region = $region;
    }


}