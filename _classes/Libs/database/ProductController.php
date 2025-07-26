<?php

namespace Libs\database;

use PDOException;

class ProductController
{
   private $db;

   public function __construct(MySQL $db)
   {
       $this->db = $db->connect();
   }

   public function getAllProducts()
   {
       try {
           $stmt = $this->db->query("SELECT * FROM products");
           return $stmt->fetchAll();
       } catch (PDOException $e) {
           echo  $e->getMessage();
           exit();
       }
   }

   public function getProductById($id)
   {
       try {
           $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
           $stmt->execute(['id' => $id]);
           return $stmt->fetch();
       } catch (PDOException $e) {
           echo  $e->getMessage();
           exit();
       }
   }

   public function updateProduct($data)
   {
         try {
            $stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price, quantity_available = :quantity_available, img = :img WHERE id = :id");
            $stmt->execute([
                  'name' => $data['name'],
                  'price' => $data['price'],
                  'quantity_available' => $data['quantity_available'],
                  'img' => $data['photo'] ?? null,
                  'id' => $data['id']
            ]);
            return $stmt->rowCount();
         } catch (PDOException $e) {
            echo  $e->getMessage();
            return false;
         }
   }

   public function deleteProduct($id)
   {
       try {
           $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
           $stmt->execute(['id' => $id]);
           return $stmt->rowCount();
       } catch (PDOException $e) {
           echo  $e->getMessage();
           return false;
       }
   }

   public function addProduct($data)
   {
       try {
           $stmt = $this->db->prepare("INSERT INTO products (name, price, quantity_available, img) VALUES (:name, :price, :quantity_available, :img)");
           $stmt->execute([
               'name' => $data['name'],
               'price' => $data['price'],
               'quantity_available' => $data['quantity_available'],
               'img' => $data['photo'] ?? null,
           ]);
           return $stmt->rowCount();
       } catch (PDOException $e) {
           echo  $e->getMessage();
           return false;
       }
   }
}