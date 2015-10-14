<?php

namespace src\ProjectWhisky\business;
use src\ProjectWhisky\data\WhiskyDAO;



class WhiskyBusiness
{
    public function getWhiskyList() 
    {
        $whiskyDAO = new WhiskyDAO();
        $whiskyList = $whiskyDAO->getAll();
        return $whiskyList;
    }
    public function getWhisky($id)
    {
        $whiskyDAO = new WhiskyDAO();
        $whisky = $whiskyDAO->getWhiskyById($id);
        return $whisky;
    }
    
    public function getWhiskyByDistillery($distilleryId)
    {
        $whiskyDAO = new WhiskyDAO();
        $whisky = $whiskyDAO->getWhiskyByDistillery($distilleryId);
        return $whisky;
    }
    
    public function getWhiskyBySearch($barrelId, $strengthMin, $strengthMax, $scoreMin, $scoreMax, $region, $ageMin, $ageMax)
    {
        $WhiskyDAO = new WhiskyDAO();
        $whiskyList = $WhiskyDAO->getWhiskiesBySearch($barrelId, $strengthMin, $strengthMax, $scoreMin, $scoreMax, $region, $ageMin, $ageMax);
        return $whiskyList;
    }
    
    public function addWhisky($name, $distillery, $price, $age, $strength, $barrel_id, $image_path, $hidden, $rating_aroma, $rating_color, $rating_taste, $rating_aftertaste, $text_aroma, $text_color, $text_taste, $text_aftertaste, $review, $user_id)
    {        
        $whiskyDAO = new WhiskyDAO();
        $whisky = $whiskyDAO->addWhisky($name, $distillery, $price, $age, $strength, $barrel_id, $image_path, $hidden, $rating_aroma, $rating_color, $rating_taste, $rating_aftertaste, $text_aroma, $text_color, $text_taste, $text_aftertaste, $review, $user_id);
        return $whisky;         
    }
    
    public function editWhisky($name, $distillery, $price, $age, $strength, $barrel_id, $image_path, $hidden, $rating_aroma, $rating_color, $rating_taste, $rating_aftertaste, $text_aroma, $text_color, $text_taste, $text_aftertaste, $review, $whisky_id)
    {
        $whiskyDAO = new WhiskyDAO();
        $whisky = $whiskyDAO->editWhisky($name, $distillery, $price, $age, $strength, $barrel_id, $image_path, $hidden, $rating_aroma, $rating_color, $rating_taste, $rating_aftertaste, $text_aroma, $text_color, $text_taste, $text_aftertaste, $review, $whisky_id);
        return $whisky; 
    }
	public function getWhiskiesByName($whiskyname)
	{
		$whiskyDAO = new WhiskyDAO();
		$whiskyList = $whiskyDAO->getWhiskiesByName($whiskyname);
		return $whiskyList;
	}


    /**
     * Delete whisky from DB
     */
    public function deleteWhisky($whiskyId)
    {
        $whiskyDAO = new WhiskyDAO();
        $whisky = $whiskyDAO->deleteWhiskyById($whiskyId);
        return $whisky;
    }
}
