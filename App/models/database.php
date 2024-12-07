<?php

class DBConnect {
    private $host = 'localhost';
    private $username = 'pkappar2_imran';
    private $password = 'Piyar1dafa!@#';
    private $db_name = 'pkappar2_wholesale_2166718';
    private $conn;
    private $charset = 'utf8mb4';
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try{
            $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=$this->charset";
            $this->pdo = new PDO($dsn, $this->username, $this->password, $this->options);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
         * @return PDO
        */
        public static function getInstance() {
            if(!isset(self::$instance)) {
                self::$instance = new DBConnect();
            }
            return self::$instance->pdo;
        }
}