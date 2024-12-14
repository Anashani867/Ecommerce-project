<?php

class CreateProductsTable
{
    public function up()
    {
        return "CREATE TABLE products (
                product_id INT PRIMARY KEY AUTO_INCREMENT,
                product_name VARCHAR(255) NOT NULL,
                description TEXT,
                price DECIMAL(10, 2) NOT NULL,
                category_id INT,
                average_rating DECIMAL(3, 2),
                stock_quantity INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES Categories(category_id)
                      )";
    }

    public function down()
    {
        $sql = "DROP TABLE products";
        return $sql;
    }

}