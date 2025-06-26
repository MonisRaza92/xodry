<?php
namespace App\Controllers;

include __DIR__. '/../../vendor/autoload.php';

use App\Models\AuthModel;
use Core\Database;

class AuthController {
     private $db;
     private $userModel;

     public function __construct() {
          $database = new Database(); // ✅ Your custom DB wrapper
          $this->db = $database->connect();
          $this->userModel = new AuthModel($this->db);
     }
     public function login() {
          error_reporting(E_ALL);
          ini_set('display_errors', 1);
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $number = trim($_POST['number']);
               $password = $_POST['password'];

               if (!filter_var($number, FILTER_VALIDATE_INT)) {
                    echo json_encode(["status" => "error", "message" => "Invalid number"]);
                    return;
               }

               $user = $this->userModel->getUserByNumber($number);

               if (!$user) {
                    // Hash the password before creating the user
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $name = "Guest"; 
                    $email = ""; 
                    $address=  "";
                    $userId = $this->userModel->createUser($name, $number, $email, $address, $hashed);
                    if ($userId) {
                          $user = $this->userModel->getUserByNumber($number);
                    } else {
                          echo json_encode(["status" => "error", "message" => "Failed to create user"]);
                          return;
                    }
               }

               // Verify password
               if (password_verify($password, $user['password'])) {
                    // Start session and set user data
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_number'] = $user['number'];

                    echo json_encode([
                         "status" => "success",
                         "message" => "Login successful",
                         "role" => $user['role']
                    ]);
               } else {
                    echo json_encode(["status" => "error", "message" => "Incorrect password"]);
                    exit;
               }
          }
     }

     public function logout() {
          session_unset();
          session_destroy();
          header("Location: home");
          exit();
     }
}
?>