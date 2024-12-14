<?php

require 'models/Model.php';

class Customer extends Model
{
    public function __construct()
    {
        parent::__construct('customers');

    }


    public function register($data)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
    (first_name, last_name, email, 	phone_number, password,address) VALUES (?, ?, ?, ?, ?,?)");

        return $statement->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['address']
        ]);
    }

    public function login($email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = ?");
        $statement->execute([$email]);  // Pass the $email parameter
        return $statement->fetch(\PDO::FETCH_ASSOC); // Adjust to fetch single user record
    }

    public function updateImage($customerId, $imagePath)
    {
        $sql = "UPDATE customers SET image_url = :image_url WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':image_url', $imagePath);
        $stmt->bindParam(':id', $customerId);
        return $stmt->execute();
    }

    public function isEmailTaken($email)
    {
        // Prepare a statement to check if the email exists
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $this->table WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Fetch the count result
        $count = $stmt->fetchColumn();

        // Return true if email exists, false otherwise
        return $count > 0;
    }

    public function getCustomerById()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customers WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateCustomer($id, $firstName, $lastName, $email, $phoneNumber, $address, $imageUrl = null)
    {
        // Prepare the SQL statement
        $sql = "UPDATE customers SET first_name = ?, last_name = ?, email = ?, phone_number = ?, address = ?, updated_at = NOW()";

        // Add image_url to the SQL if it's provided
        if ($imageUrl) {
            $sql .= ", image_url = ?";
        }
        $sql .= " WHERE id = ?";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind parameters
        if ($imageUrl) {
            return $stmt->execute([$firstName, $lastName, $email, $phoneNumber, $address, $imageUrl, $id]);
        } else {
            return $stmt->execute([$firstName, $lastName, $email, $phoneNumber, $address, $id]);
        }
    }

    public function countCustomers()
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM customers");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->count;
    }


}