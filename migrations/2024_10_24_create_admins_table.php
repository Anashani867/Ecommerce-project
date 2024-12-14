<?php

class CreateAdminsTable
{
    public function up() {
        return 'CREATE TABLE `Admins ` ('
            . '`admin_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,'
            . '`username ` VARCHAR(255) NOT NULL,'
            . '`email ` VARCHAR(255) NOT NULL UNIQUE,'
            . '`password ` VARCHAR(255) NOT NULL,'
            . 'role VARCHAR(255) NOT NULL,'
            . 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,'
            . ' updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,';
    }

    public function down()
    {
        $sql = "DROP TABLE Admins ";
        return $sql;
    }

}