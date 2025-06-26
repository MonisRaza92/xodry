<?php

namespace App\Models;

require_once __DIR__ . '/../../core/Database.php';

use Core\Database;
use PDO;
use PDOException;


class AuthModel
{
     private $db;

     public function __construct($db)
     {
          $this->db = $db; 
     }

     public function userExists($number)
     {
          try {
               $stmt = $this->db->prepare("SELECT * FROM users WHERE number = ?");
               $stmt->execute([$number]);
               return $stmt->rowCount() > 0;
          } catch (PDOException $e) {
               return false; // Or log error if needed
          }
     }

     public function createUser($name, $number, $email, $address, $hashed)
     {
          try {
               $stmt = $this->db->prepare("INSERT INTO users (name, number, email, address, password) VALUES (?, ?, ?, ?, ?)");
               $stmt->execute([$name, $number, $email, $address, $hashed]);
               return true;
          } catch (PDOException $e) {
               return $e->getMessage();
          }
     }
     public function createRider($name, $number, $email, $address, $hashed, $role = 'rider')
     {
          try {
               $stmt = $this->db->prepare("INSERT INTO users (name, number, email, address, password, role) VALUES (?, ?, ?, ?, ?, ?)");
               $stmt->execute([$name, $number, $email, $address, $hashed, $role]);
               return true;
          } catch (PDOException $e) {
               return $e->getMessage();
          }
     }
     public function getUserByNumber($number)
     {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE number = ?");
          $stmt->execute([$number]);
          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function deleteUser($id)
     {
          try {
               $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
               $stmt->execute([$id]);
               return $stmt->rowCount() > 0;
          } catch (PDOException $e) {
               return false;
          }
     }

     public function changePassword($id, $hashedPassword)
     {
          try {
               $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
               $stmt->execute([$hashedPassword, $id]);
               return $stmt->rowCount() > 0;
          } catch (PDOException $e) {
               return false;
          }
     }
}
