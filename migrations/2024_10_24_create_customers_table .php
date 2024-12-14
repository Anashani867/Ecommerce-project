<?php

class CreateCustomersTable
{
    public function up() {
        return 'CREATE TABLE `customers  ` ('
            . '`customers _id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,'
            . '`username ` VARCHAR(255) NOT NULL,'
            . 'first_name VARCHAR(255) NOT NULL,'
            . 'last_name VARCHAR(255) NOT NULL,'
            . '`email ` VARCHAR(255) NOT NULL UNIQUE,'
            . '`password ` VARCHAR(255) NOT NULL,'
            . 'phone_number VARCHAR(20),'
            . 'img_url VARCHAR(255),'
            . 'address Text NOT NULL,'
            . 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,'
            . ' updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,';
    }

    public function down()
    {
        $sql = "DROP TABLE customers  ";
        return $sql;
    }

}