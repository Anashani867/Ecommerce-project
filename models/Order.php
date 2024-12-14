<?php
require_once 'models/Model.php';

class Order extends Model
{
    public function __construct()
    {
        parent::__construct('orders');
    }
    public function create($data)
    {
        if (isset($data['customer_id'], $data['total_amount'], $data['address'], $data['phone_number'])) {
            $stmt = $this->pdo->prepare("INSERT INTO orders (customer_id, order_date, status, coupon_id, total_amount, address, phone_number, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
            try {
                $stmt->execute([
                    $data['customer_id'],
                    $data['order_date'],
                    $data['status'],
                    $data['coupon_id'],
                    $data['total_amount'],
                    $data['address'],
                    $data['phone_number'],
                    $data['created_at'],
                    $data['updated_at']
                ]);
    
                // Return the last inserted order ID
                return $this->pdo->lastInsertId();
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                throw new Exception("Database error: " . $e->getMessage());
            }
        } else {
            throw new Exception("Missing required fields: customer_id, total_amount, address, and phone_number");
        }
    }
    

    public function updateStatus($orderId, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE $this->table SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $orderId]);

        return $stmt->rowCount(); // Return the number of affected rows
    }

    public function getStatusById($orderId)
    {
        $stmt = $this->pdo->prepare("SELECT status FROM $this->table WHERE id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchColumn(); // Returns the status of the order
    }

    public function canCancelOrder($orderId)
    {
        $stmt = $this->pdo->prepare("SELECT created_at FROM $this->table WHERE id = ?");
        $stmt->execute([$orderId]);
        $createdAt = $stmt->fetchColumn();

        if ($createdAt) {
            $orderTime = new DateTime($createdAt);
            $currentTime = new DateTime();
            $interval = $currentTime->diff($orderTime);

            return $interval->h < 24 || $interval->days === 0; // Check if within 24 hours
        }

        return false;
    }

    public function countOrders()
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM orders");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->count;
    }

    public function totalOrders()
    {
        $stmt = $this->pdo->prepare("SELECT SUM(total_amount) AS total FROM orders");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getSalesData()
    {
        $statement = $this->pdo->prepare('SELECT order_date, total_amount FROM orders ORDER BY order_date ASC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}
