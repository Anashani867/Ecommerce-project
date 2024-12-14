<?php

class CreateReviewsTable
{
    public function up()
    {
        return "CREATE TABLE reviews    (
                review_id INT PRIMARY KEY AUTO_INCREMENT,
                product_id INT,
                customer_id INT,
                rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
                comment TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(product_id),
                FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
                      )";
    }

    public function down()
    {
        $sql = "DROP TABLE reviews   ";
        return $sql;
    }

}