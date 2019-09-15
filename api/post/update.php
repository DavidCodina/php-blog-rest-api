<?php
  //////////////////////////////////////////////////////////////////////////////
  //
  //  Tested in Postman in video 3 @03:48 using the following URL:
  //  http://localhost/php_rest_myblog/api/post/update.php
  //  We specify the method in Postman as PUT.
  //  Then in the 'Headers' tab we specify: Content-Type as application/json
  //
  //  In the 'Body' Tab of Postman we choose 'raw'
  //
  //  Then we input this:
  //
  // {
  //   "title"       : "Update Test 1",
  //   "body"        : "This is a test...",
  //   "author"      : "David Codina",
  //   "category_id" : "1",
  //   "id"          : "4"
  // }
  //
  //
  //  Upon sending in Postman we get back: { "message": "Post Updated" }
  //  And if we look at the myblog database, we will see the added post.
  //
  //
  //////////////////////////////////////////////////////////////////////////////


  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT'); //PUT
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/Post.php';


  $database = new Database();                                //Instantiate new Database
  $db       = $database->connect();                          //Establish connection
  $post     = new Post($db);                                 //Instantiate blog post object
  $data     = json_decode(file_get_contents("php://input")); //Get raw posted data


  $post->id          = $data->id; //Set ID to update
  $post->title       = $data->title;
  $post->body        = $data->body;
  $post->author      = $data->author;
  $post->category_id = $data->category_id;


  //Update post
  if( $post->update() ) {
    echo json_encode( array('message' => 'Post Updated') );
  } else {
    echo json_encode( array('message' => 'Post Not Updated') );
  }
