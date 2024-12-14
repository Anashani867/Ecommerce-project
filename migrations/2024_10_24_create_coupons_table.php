<?php

class CreateCouponsTable
{
    public function up()
    {
        return "CREATE TABLE coupons  (
                coupon_id INT PRIMARY KEY AUTO_INCREMENT,
                code VARCHAR(50) NOT NULL UNIQUE,
                discount DECIMAL(5, 2) NOT NULL,
                usage_limit INT,
                expiration_date TIMESTAMP,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                      )";
    }

    public function down()
    {
        $sql = "DROP TABLE coupons ";
        return $sql;
    }

}