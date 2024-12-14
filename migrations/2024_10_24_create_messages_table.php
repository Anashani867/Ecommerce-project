<?php

class CreateMessagesTable
{
    public function up()
    {
        return "CREATE TABLE Messages   (
                message_id INT PRIMARY KEY AUTO_INCREMENT,
                customer_id INT,
                admin_id INT,
                content TEXT NOT NULL,
                status ENUM('resolved', 'unresolved'),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
                FOREIGN KEY (admin_id) REFERENCES Admins(admin_id)
                      )";
    }

    public function down()
    {
        $sql = "DROP TABLE Messages  ";
        return $sql;
    }

}