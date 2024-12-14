<?php
require_once 'models/Model.php';
class Review extends Model {
    public function __construct() {
        parent::__construct('reviews');
    }

    // Method to add a new review
    public function addReview($data) {
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = 'public/uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $data['image_url'] = $imagePath; // Add the image URL to the data array
        } else {
            $data['image_url'] = null; // If no image, set to null
        }

        $statement = $this->pdo->prepare(
            "INSERT INTO reviews (product_id, customer_id, rating, comment, image_url, created_at) 
         VALUES (:product_id, :customer_id, :rating, :comment, :image_url, NOW())"
        );
        return $statement->execute([
            ':product_id' => $data['product_id'],
            ':customer_id' => $data['customer_id'],
            ':rating' => $data['rating'],
            ':comment' => $data['comment'],
            ':image_url' => $data['image_url'] // Include the image URL
        ]);
    }


    // Method to get reviews for a specific product
    public function getReviewsByProductId($productId) {
        $statement = $this->pdo->prepare(
            "SELECT reviews.*, customers.first_name, customers.last_name, customers.image_url AS customer_image
             FROM reviews
             JOIN customers ON reviews.customer_id = customers.id
             WHERE reviews.product_id = :product_id
             ORDER BY reviews.created_at DESC"
        );        
        $statement->execute([':product_id' => $productId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteReview($reviewId) {
        $statement = $this->pdo->prepare("DELETE FROM reviews WHERE id = :id");
        return $statement->execute([':id' => $reviewId]);
    }
    public function acceptReview($reviewId) {
        $statement = $this->pdo->prepare("UPDATE reviews SET status = 'accepted' WHERE id = :id");
        return $statement->execute([':id' => $reviewId]);
    }
    
    public function rejectReview($reviewId) {
        $statement = $this->pdo->prepare("UPDATE reviews SET status = 'rejected' WHERE id = :id");
        return $statement->execute([':id' => $reviewId]);
    }

}
