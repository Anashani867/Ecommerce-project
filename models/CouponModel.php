<?php
require_once 'models/Model.php';

class CouponModel extends Model
{
    public function __construct()
    {
        parent::__construct('coupons'); // Assuming your table name is 'coupons'
    }

    // Get coupons by product ID
    public function getCouponsByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table WHERE product_id = :product_id ORDER BY created_at DESC";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new coupon
    public function createCoupon($productId, $discount, $expirationDate)
    {
        $sql = "INSERT INTO $this->table (product_id, discount, expiration_date) VALUES (:product_id, :discount, :expiration_date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':discount', $discount, PDO::PARAM_STR);
        $stmt->bindParam(':expiration_date', $expirationDate, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    public function addCoupon($code, $discount, $usageLimit = null, $expirationDate = null)
    {
        $stmt = $this->pdo->prepare("INSERT INTO coupons (code, discount, usage_limit, expiration_date) VALUES (:code, :discount, :usage_limit, :expiration_date)");
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':discount', $discount, PDO::PARAM_STR);
        $stmt->bindParam(':usage_limit', $usageLimit, PDO::PARAM_INT);
        $stmt->bindParam(':expiration_date', $expirationDate, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Delete a coupon
    public function CouponDelete($couponId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE id = :id");
        $stmt->bindParam(':id', $couponId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getCouponByCode($code)
{
    $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE code = :code");
    $stmt->bindParam(':code', $code, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
