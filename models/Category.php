<?php
  class Category {
    //DB Stuff
    private $conn;
    private $table = 'categories';

    //Properties
    public $id;
    public $name;
    public $created_at;

    /* ============================
          Constructor
    ============================ */


    public function __construct($db) {
      $this->conn = $db;
    }


    /* ============================
        read() - get categories
    ============================ */


    public function read(){
      //Create the query
      $query = 'SELECT
        id,
        name,
        created_at
        FROM ' . $this->table . '
        ORDER BY
        created_at DESC';


      $stmt = $this->conn->prepare($query); //Prepare the statement
      $stmt->execute();                     //Execute the query

      return $stmt;
    }


    /* ============================
    read_single() - Get Single Category
    ============================ */


    public function read_single(){
      // Create the query
      $query = 'SELECT
               id,
               name
               FROM ' . $this->table . '
               WHERE id = ?
               LIMIT 0,1';

        $stmt = $this->conn->prepare($query); //Prepare statement
        $stmt->bindParam(1, $this->id);       //Bind the id
        $stmt->execute();                     //Execute the query
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Set the properties
        $this->id   = $row['id'];
        $this->name = $row['name'];
    }


    /* ============================
        create() - Create the Category
    ============================ */


    public function create(){
      $query      = 'INSERT INTO ' . $this->table . ' SET name = :name'; //Create the query
      $stmt       = $this->conn->prepare($query);                        //Prepare Statement
      $this->name = htmlspecialchars(strip_tags($this->name));           //Sanitize the data
      $stmt-> bindParam(':name', $this->name);                           //Bind the data

      //Execute the query
      if($stmt->execute()) {
        return true;
      }

      //Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);

      return false;
    }


    /* ============================
      update() - Update Category
    ============================ */


    public function update() {
      $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id'; //Create  the Query
      $stmt  = $this->conn->prepare($query);                                  //Prepare the statement

      //Sanitize the data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->id   = htmlspecialchars(strip_tags($this->id));

      //Bind the data
      $stmt-> bindParam(':name', $this->name);
      $stmt-> bindParam(':id', $this->id);

      //Execute the query
      if( $stmt->execute() ) {
        return true;
      }

      //Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);

      return false;
    }


    /* ============================
        delete() - Delete Category
    ============================ */


    public function delete() {
      $query    = 'DELETE FROM ' . $this->table . ' WHERE id = :id'; //Create  the query
      $stmt     = $this->conn->prepare($query);                      //Prepare the Statement
      $this->id = htmlspecialchars(strip_tags($this->id));           //Sanitize the data

      //Bind the data
      $stmt-> bindParam(':id', $this->id);

      //Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);

      return false;
      }
  }
