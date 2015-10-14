<?php

namespace src\ProjectWhisky\entities;

Class Whisky
{
    private $id;
    private $name;
    private $distilleryId;
    private $price;
    private $age;
    private $strength;
    private $barrelId;
    private $imagePath;
    private $hidden;
    private $creationDate;
    private $ratingAroma;
    private $ratingColor;
    private $ratingTaste;
    private $ratingAftertaste;
    private $textAroma;
    private $textColor;
    private $textTaste;
    private $textAftertaste;
    private $review;
    private $userId;


    // CONSTRUCTOR
    
    public function __construct($id, $name, $distilleryId, $price, $age, $strength, $barrelId, $imagePath, $hidden, $creationDate, $ratingAroma, $ratingColor, $ratingTaste, $ratingAftertaste, $textAroma, $textColor, $textTaste, $textAftertaste, $review, $userId)
    {
     $this->id = $id;
     $this->name = $name;
     $this->distilleryId = $distilleryId;
     $this->price = $price;
     $this->age = $age;
     $this->strength = $strength;
     $this->barrelId = $barrelId;
     $this->imagePath = $imagePath;
     $this->hidden = $hidden;
     $this->creationDate = $creationDate;
     $this->ratingAroma = $ratingAroma;
     $this->ratingColor = $ratingColor;
     $this->ratingTaste = $ratingTaste;
     $this->ratingAftertaste = $ratingAftertaste;
     $this->textAroma = $textAroma;
     $this->textColor = $textColor;
     $this->textTaste = $textTaste;
     $this->textAftertaste = $textAftertaste;
     $this->review = $review;
     $this->userId = $userId;
    }

    
    // ACCESSORS (getters)
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDistilleryId()
    {
        return $this->distilleryId;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function getBarrelId()
    {
        return $this->barrelId;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function getHidden()
    {
        return $this->hidden;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getRatingAroma()
    {
        return $this->ratingAroma;
    }

    public function getRatingColor()
    {
        return $this->ratingColor;
    }

    public function getRatingTaste()
    {
        return $this->ratingTaste;
    }

    public function getRatingAftertaste()
    {
        return $this->ratingAftertaste;
    }

    public function getTextAroma()
    {
        return $this->textAroma;
    }

    public function getTextColor()
    {
        return $this->textColor;
    }

    public function getTextTaste()
    {
        return $this->textTaste;
    }

    public function getTextAftertaste()
    {
        return $this->textAftertaste;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function getUserId()
    {
        return $this->userId;
    }

//======================================
    // TRANSFORMERS robots in disguise (setters)
//======================================
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDistilleryId($distilleryId)
    {
        $this->distilleryId = $distilleryId;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function setStrength($strength)
    {
        $this->strength = $strength;
    }

    public function setBarrelId($barrelId)
    {
        $this->barrelId = $barrelId;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setRatingAroma($ratingAroma)
    {
        $this->ratingAroma = $ratingAroma;
    }

    public function setRatingColor($ratingColor)
    {
        $this->ratingColor = $ratingColor;
    }

    public function setRatingTaste($ratingTaste)
    {
        $this->ratingTaste = $ratingTaste;
    }

    public function setRatingAftertaste($ratingAfteraste)
    {
        $this->ratingAftertaste = $ratingAfteraste;
    }

    public function setTextAroma($textAroma)
    {
        $this->textAroma = $textAroma;
    }

    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;
    }

    public function setTextTaste($textTaste)
    {
        $this->textTaste = $textTaste;
    }

    public function setTextAftertaste($textAftertaste)
    {
        $this->textAftertaste = $textAftertaste;
    }

    public function setReview($review)
    {
        $this->review = $review;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

}