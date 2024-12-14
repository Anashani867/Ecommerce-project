<?php
require_once 'models/Model.php';

class ProductImage extends Model 
{
    public function __construct()
    {
        parent::__construct('productimages');
    }

    public function update($productId, $imageUrl)
    {
        $statement = $this->pdo->prepare("
            UPDATE productimages 
            SET image_url = :image_url 
            WHERE product_id = :product_id
        ");
        $statement->bindParam(':image_url', $imageUrl, PDO::PARAM_STR);
        $statement->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $statement->execute();
    }
}
