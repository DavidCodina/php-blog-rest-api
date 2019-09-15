<?php
  class Post {
    //Database properties
    private $conn;
    private $table = 'posts';

    //Post Properties
    public $id;
    public $category_id;
    //We don't have a category_name field in the database.
    //However, we will use a JOIN in the query to combine the tables to obtain
    //The category name of the post.
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;


    /* ============================
          Constructor
    ============================ */


    public function __construct($db){
      $this->conn = $db;
    }


    /* ============================
            read() - get Posts
    ============================ */


    public function read(){
      //Create the query
      $query = 'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                FROM ' . $this->table . ' p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC';


      $stmt = $this->conn->prepare($query); //Prepare the statement
      $stmt->execute();                     //Execute the query

      return $stmt;
    }


    /* ============================
    read_single() - Get Single Post
    ============================ */


    public function read_single(){
      //Create the query
      $query = 'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                FROM ' . $this->table . ' p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = ?
                LIMIT 0,1';


      $stmt = $this->conn->prepare($query); //Prepare the statement
      $stmt->bindParam(1, $this->id);       //Bind the ID
      $stmt->execute();                     //Execute the query

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //Set the properties
      $this->title         = $row['title'];
      $this->body          = $row['body'];
      $this->author        = $row['author'];
      $this->category_id   = $row['category_id'];
      $this->category_name = $row['category_name'];
    }


    /* ============================
        create() - Create Post
    ============================ */


    public function create(){
      //Create the query
      $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';
      $stmt  = $this->conn->prepare($query); //Prepare the statement


      //Sanitize the data
      $this->title       = htmlspecialchars( strip_tags($this->title)       );
      $this->body        = htmlspecialchars( strip_tags($this->body)        );
      $this->author      = htmlspecialchars( strip_tags($this->author)      );
      $this->category_id = htmlspecialchars( strip_tags($this->category_id) );


      //Bind the data
      $stmt->bindParam(':title',       $this->title);
      $stmt->bindParam(':body',        $this->body);
      $stmt->bindParam(':author',      $this->author);
      $stmt->bindParam(':category_id', $this->category_id);


      //Execute the query
      if( $stmt->execute() ){
        return true;
      }

      //Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }


    /* ============================
          update() - Update Post
    ============================ */


    public function update() {
      //Create the query
      $query = 'UPDATE ' . $this->table . '
               SET title = :title, body = :body, author = :author, category_id = :category_id
               WHERE id = :id';


      $stmt = $this->conn->prepare($query); //Prepare the statement


      //Sanitize the data
      $this->title       = htmlspecialchars(strip_tags($this->title));
      $this->body        = htmlspecialchars(strip_tags($this->body));
      $this->author      = htmlspecialchars(strip_tags($this->author));
      $this->category_id = htmlspecialchars(strip_tags($this->category_id));
      $this->id          = htmlspecialchars(strip_tags($this->id));


      //Bind the data
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':body', $this->body);
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':category_id', $this->category_id);
      $stmt->bindParam(':id', $this->id);

      //Execute the query
      if( $stmt->execute() ){
        return true;
      }

      //Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }


    /* ============================
        delete() - Delete Post
    ============================ */


    public function delete(){
      $query    = 'DELETE FROM ' . $this->table . ' WHERE id = :id'; //Create the query
      $stmt     = $this->conn->prepare($query);                      //Prepare the statement
      $this->id = htmlspecialchars(strip_tags($this->id));           //Sanitize the data
      $stmt->bindParam(':id', $this->id);                            //Bind the data

      //Execute query
      if( $stmt->execute() ){
        return true;
      }

      //Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  } //End of class Post
