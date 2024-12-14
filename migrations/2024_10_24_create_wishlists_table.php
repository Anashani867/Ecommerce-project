<?php

class CreateWishlistsTable
{
    public function up()
    {
        return "CREATE TABLE wishlists    (
              wishlist_id INT PRIMARY KEY AUTO_INCREMENT,
              customer_id INT,
              product_id INT,
              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
              FOREIGN KEY (product_id) REFERENCES products(product_id)
                      )";
    }

    public function down()
    {
        $sql = "DROP TABLE wishlists   ";
        return $sql;
    }

}