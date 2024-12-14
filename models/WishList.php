<?php
require_once 'models/Model.php';  

class Wishlist extends Model {
    public function __construct() {
        parent::__construct('wishlists'); // Initialize with the 'wishlists' table
    }

    public function getWishlistItems($customerId)
    {
        $statement = $this->pdo->prepare("
            SELECT w.product_id, 
                   p.product_name, 
                   p.price, 
                   (SELECT pi.image_url 
                    FROM productimages pi 
                    WHERE pi.product_id = p.id 
                    LIMIT 1) AS image_url
            FROM wishlists w
            JOIN products p ON w.product_id = p.id
            WHERE w.customer_id = :customer_id
        ");
        
        $statement->bindParam(':customer_id', $customerId);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    public function addToWishlist($customerId, $productId) {
        // Check if the product is already in the wishlist
        $existsStmt = $this->pdo->prepare("SELECT COUNT(*) FROM wishlists WHERE customer_id = ? AND product_id = ?");
        $existsStmt->execute([$customerId, $productId]);
        $exists = $existsStmt->fetchColumn();

        // If the product already exists in the wishlist, return false
        if ($exists > 0) {
            return false; // Product already in wishlist
        }

        // Prepare your SQL query to insert into the wishlists table
        $stmt = $this->pdo->prepare("INSERT INTO wishlists (customer_id, product_id, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$customerId, $productId]); // Return the result of the execution
    }
    public function removeItem($itemId) {
        $stmt = $this->pdo->prepare("DELETE FROM wishlists WHERE product_id = :id"); // Ensure 'product_id' is the correct field in the DB
        return $stmt->execute([':id' => $itemId]); // Execute the query
    }

    
}

