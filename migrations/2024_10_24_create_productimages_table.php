<?php

class CreateProductImagesTable
{
    public function up()
    {
        return "CREATE TABLE productimages     (
                image_id INT PRIMARY KEY AUTO_INCREMENT,
                product_id INT,
                image_url VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(product_id)
                      )";
    }

    public function down()
    {
        $sql = "DROP TABLE productimages   ";
        return $sql;
    }

}