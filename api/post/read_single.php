<?php
  //Tested @9:55 (video 2) in Postman.
  //We used a GET request and the following URL:
  //http://localhost/php_rest_myblog/api/post/read_single.php?id=3
  
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');


  include_once '../../config/Database.php';
  include_once '../../models/Post.php';


  $database = new Database();                           //Instantiate new Database
  $db       = $database->connect();                     //Establish connection
  $post     = new Post($db);                            //Instantiate blog post object
  $post->id = isset($_GET['id']) ? $_GET['id'] : die(); //Get the id from the URL.


  //Get post
  $post->read_single();


  //Create array
  $post_arr = array(
    'id'            => $post->id,
    'title'         => $post->title,
    'body'          => $post->body,
    'author'        => $post->author,
    'category_id'   => $post->category_id,
    'category_name' => $post->category_name
  );



  //Make JSON
  print_r(json_encode($post_arr));
