<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE'); //DELETE
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/Post.php';


  $database = new Database();                                //Instantiate new Database
  $db       = $database->connect();                          //Establish connection
  $post     = new Post($db);                                 //Instantiate blog post object
  $data     = json_decode(file_get_contents("php://input")); //Get raw posted data

  $post->id = $data->id;


  //Delete post
  if($post->delete()) {
    echo json_encode( array('message' => 'Post Deleted') );
  } else {
    echo json_encode( array('message' => 'Post Not Deleted') );
  }
