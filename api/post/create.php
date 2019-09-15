<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST'); //Allow POST requests;
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/Post.php';


  $database = new Database();                                //Instantiate new Database
  $db       = $database->connect();                          //Establish connection
  $post     = new Post($db);                                 //Instantiate blog post object
  $data     = json_decode(file_get_contents("php://input")); //Get raw posted data


  $post->title       = $data->title;
  $post->body        = $data->body;
  $post->author      = $data->author;
  $post->category_id = $data->category_id;


  //Create post
  if( $post->create() ) {
    echo json_encode( array('message' => 'Post Created') );
  } else {
    echo json_encode( array('message' => 'Post Not Created') );
  }
