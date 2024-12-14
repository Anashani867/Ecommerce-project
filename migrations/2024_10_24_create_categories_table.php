<?php

class CreateCategoriesTable
{
    public function up()
    {
        return 'CREATE TABLE `categories` ('
            . '`category_id` int NOT NULL AUTO_INCREMENT,'
            . '`category_name` VARCHAR(255) NOT NULL,'
            . '`image_url` VARCHAR(255),'
            . 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,'
            . ' updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
            . 'PRIMARY KEY (`category_id`)';
    }

    public function down()
    {
        $sql = "DROP TABLE categories";
        return $sql;
    }

}