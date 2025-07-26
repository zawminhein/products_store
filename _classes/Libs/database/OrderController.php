<?php

namespace Libs\database;

use PDOException;

class OrderController
{
    private $db;

    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function createOrder($data)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO orders (username, product_id, qty) VALUES (:username, :product_id, :qty)");
            $stmt->execute([
                'username' => $data['username'],
                'product_id' => $data['product_id'],
                'qty' => $data['qty'],
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo  $e->getMessage();
            return false;
        }
    }

    public function getOrdersByUserId($userId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo  $e->getMessage();
            return [];
        }
    }

   public function getAllOrders()
   {
      try {
            $stmt = $this->db->query("SELECT * FROM orders");
            return $stmt->fetchAll();
      } catch (PDOException $e) {
            echo  $e->getMessage();
            return [];
      }
   }
}