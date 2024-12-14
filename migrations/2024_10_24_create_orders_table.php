<?php

class CreateOrdersTable
{
    public function up()
    {
        return "CREATE TABLE orders    (
                order_id INT PRIMARY KEY AUTO_INCREMENT,
                customer_id INT,
                order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                status ENUM('pending', 'completed', 'cancelled') NOT NULL,
                coupon_id INT,
                total_amount DECIMAL(10, 2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
                FOREIGN KEY (coupon_id) REFERENCES coupons(coupon_id)
                      )";
    }

    public function down()
    {
        $sql = "DROP TABLE orders   ";
        return $sql;
    }

}