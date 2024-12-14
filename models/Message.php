<?php

require 'models/Model.php';

class Message extends Model {

    public function __construct()
    {
        parent::__construct('messages');

    }

    public function saveMessage() {
        // Prepare the SQL statement
        $statement = $this->pdo->prepare("
        INSERT INTO $this->table (customer_id, content, created_at) 
        VALUES (:customer_id, :content, NOW())
    ");

        // Bind parameters
        $statement->bindParam(':customer_id', $_SESSION['user']['id'], PDO::PARAM_INT);
        $statement->bindParam(':content', $_POST['message'], PDO::PARAM_STR);

        // Execute and return the result
        return $statement->execute();
    }

    public function getMessagesWithCustomerNames()
    {
        $sql = "SELECT messages.*, 
                   CONCAT(customers.first_name, ' ', customers.last_name) AS customer_name
            FROM messages
            LEFT JOIN customers ON messages.customer_id = customers.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}