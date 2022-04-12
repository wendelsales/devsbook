<?php

namespace src\models;

use \core\Model;

class User extends Model
{
    public $id;
    public $email;
    public $name;
    public $avatar;


    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function setAvatar($avatar)
    {
        $this->avatar = 'avatar.jpg';
    }
}
