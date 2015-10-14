<?php

namespace src\ProjectWhisky\business;
use src\ProjectWhisky\data\BarrelDAO;



class BarrelBusiness
{
    public function showAllBarrels()
    {
        $barrelDAO = new BarrelDAO();
        $barrelList = $barrelDAO->getAll();
        return $barrelList;
    }
    
    
    public function showBarrel($whiskyId) 
    {
        $barrelDAO = new BarrelDAO();
        $barrel = $barrelDAO->getBarrelByWhisky($whiskyId);
        return $barrel;
    }
    
    public function showBarrelById($id)
    {
        $barrelDAO = new BarrelDAO();
        $barrel = $barrelDAO->getBarrelById($id);
        return $barrel;
    }
            
    public function addBarrel($type)
    {
        $barrelDAO = new BarrelDAO();
        $barrel = $barrelDAO->addBarrel($type);
        return $barrel;   
    }
    
    public function editBarrel($id, $type)
    {
        $barrelDAO = new BarrelDAO();
        $barrel = $barrelDAO->editBarrel($id, $type);
        return $barrel;
    }        
}