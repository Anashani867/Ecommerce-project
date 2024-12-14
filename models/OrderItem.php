<?php

require_once 'models/Model.php';    

class OrderItem extends Model 
{
    public function __construct()
    {
        parent::__construct('orderitems'); // Assuming the table name is 'order_items'
    }

    public function create($data)
    {
        parent::create($data);
    }

    public function getOrderDetails()
    {
        $stmt = $this->pdo->prepare(
            "SELECT o.id AS order_id,
                o.order_date,
                o.status,
                o.total_amount,
                oi.product_id,
                oi.quantity,
                oi.price,
                p.product_name,
                p.price AS product_price
         FROM orders o
         JOIN orderitems oi ON o.id = oi.order_id
         JOIN products p ON oi.product_id = p.id
         WHERE o.customer_id = :customer_id"
        );

        $stmt->bindParam(':customer_id', $_SESSION['user']['id'], PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}
