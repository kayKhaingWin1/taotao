<?php
include_once __DIR__ . '/../model/Township.php';

class TownshipController {
    private $township;

    public function __construct()
    {
        $this->township = new Township();
    }

    public function getTownships()
    {
        return $this->township->getTownships();
    }

    public function getTownship($id)
    {
        return $this->township->getTownship($id);
    }

    public function addTownship($name,$fee)
    {
        return $this->township->addTownship($name,$fee);
    }

    public function editTownship($id, $name,$fee)
    {
        return $this->township->editTownship($id, $name,$fee);
    }

    public function deleteTownship($id)
    {
        return $this->township->deleteTownship($id);
    }
}
