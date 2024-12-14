<?php

require 'models/Model.php';

class Admin extends Model
{
    public function __construct()
    {
        parent::__construct('admins');

    }

    public function login($email) {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = ?");
        $statement->execute([$email]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

}