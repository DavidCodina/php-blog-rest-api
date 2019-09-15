<?php
  //////////////////////////////////////////////////////////////////////////////
  //
  //
  //  Tested in Postman in video 2 @22:30 using a POST request, and the following URL:
  //  http://localhost/php_rest_myblog/api/post/create.php
  //  Then in headers we specify the Content-Type as application/json
  //  In the 'Body' Tab of Postman we choose 'raw'
  //
  //  Then we input this:
  //
  //    {
  //      "title"       : "My Tech Post",
  //      "body"        : "This is a test...",
  //      "author"      : "David Codina",
  //      "category_id" : "1"
  //    }
  //
  //
  //  Upon sending in Postman we get back: { "message": "Post Created" }
  //  And if we look at the myblog database, we will see the added post.
  //
  //////////////////////////////////////////////////////////////////////////////


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
