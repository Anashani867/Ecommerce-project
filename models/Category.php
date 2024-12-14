<?php

require_once 'models/Model.php';

class Category extends Model
{

    public function __construct()
    {
        parent::__construct('categories');

    }
    public function getAllCategories()
    {
        $statement = $this->pdo->prepare("
        SELECT id, category_name
        FROM $this->table
        ");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

}