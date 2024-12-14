<?php

class CreateOrdersProductsTable
{
    public function up()
    {
        return "CREATE TABLE ordersproducts    (
               order_item_id INT PRIMARY KEY AUTO_INCREMENT,
               order_id INT,
               product_id INT,
               quantity INT NOT NULL,
               price DECIMAL(10, 2) NOT NULL,
               FOREIGN KEY (order_id) REFERENCES orders(order_id),
               FOREIGN KEY (product_id) REFERENCES products(product_id)
                      )";
    }

    public function down()
    {
        $sql = "DROP TABLE ordersproducts   ";
        return $sql;
    }

}