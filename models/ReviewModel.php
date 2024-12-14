<?php
require_once 'models/Model.php';
class ReviewModel extends Model
{
    public function __construct()
    {
        parent::__construct('reviews');
    } 
       public function getReviewsByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table WHERE product_id = :product_id ORDER BY created_at DESC";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteReview($reviewId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}