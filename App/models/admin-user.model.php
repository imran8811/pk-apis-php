<?php

require_once('database.php');

class AdminUserModel {
  public $pdo;

    public function __construct() {
        $this->pdo = DBConnect::getInstance();
    }      
  
  public function login($email, $password){
    $query = 'SELECT * FROM admin_users WHERE email=? AND password=? ';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$email, $password]);
    $res = $stmt->fetch();
    return $res;
  }
}