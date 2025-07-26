<?php

namespace Libs\database;

use PDOException;

class UserController
{
    private $db;

    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function createUser($data)
    {
        try {
            
            $statement = $this->db->prepare(
                "INSERT INTO users (name, email, password, role) VALUES ( :name, :email, :password, :role )"
            );

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);  //** security
            $data['role'] = 'user'; // Default role for new users

            $statement->execute($data);

            return $this->db->lastInsertId();

        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function loginUser($data)
    {
      try {
            $statement = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $statement->execute(['email' => $data['email']]);
            $user = $statement->fetch();

            if($user) 
            {
               if(password_verify($data['password'], $user->password))
               {
                  return $user;
               }
            }

            return false; // Invalid credentials

      } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
      }
    }
}