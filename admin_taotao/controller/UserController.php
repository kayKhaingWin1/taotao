<?php
include_once __DIR__ . '/../model/User.php';

class UserController {
    private $user;

    function __construct()
    {
        $this->user = new User();
    }

    public function getUser($id)
    {
        return $this->user->getUser($id);
    }

    public function getAllUsers()
    {
        return $this->user->getAllUsers();
    }

    public function getUserByEmail($email)
    {
        return $this->user->getUserByEmail($email);
    }

}