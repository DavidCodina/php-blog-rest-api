<?php
  //The file is give an capital D (i.e., Database.php).
  //By convention files that contain a single class are given a name corresponding to that class.


  class Database {
    //Database Parameters
    private $host     = 'localhost';
    private $db_name  = 'myblog'; //Change this when deploying to remote server.
    private $username = 'root';   //Change this when deploying to remote server.
    private $password = '';       //Change this when deploying to remote server.
    private $conn;


    //Create a method to connect.
    public function connect() {
      $this->conn = null; //Set $conn to null initially.

      try {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }
?>
