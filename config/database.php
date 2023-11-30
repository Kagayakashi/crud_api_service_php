<?php
class Database {
    
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function set_host($host){
        $this->host = $host;
    }

    public function set_database($db_name){
        $this->db_name = $db_name;
    }

    public function set_username($username){
        $this->username = $username;
    }

    public function set_password($password){
        $this->password = $password;
    }

    // получаем соединение с БД 
    public function getConnection(){

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
