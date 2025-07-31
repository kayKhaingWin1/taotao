<?php
include_once __DIR__ . '/../model/Township.php';

class TownshipController
{
    private $township;

    public function __construct()
    {
        $this->township = new Township();
    }

    public function getAllTownships()
    {
        return $this->township->getAllTownships();
    }

    public function getTownshipById($id)
    {
        return $this->township->getTownshipById($id);
    }
}
