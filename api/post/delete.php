<?php
  //////////////////////////////////////////////////////////////////////////////
  //
  //  Tested in Postman in video 3 @08:08 using the following URL:
  //  http://localhost/php_rest_myblog/api/post/delete.php
  //  We specify the method in Postman as DELETE.
  //  Then in the 'Headers' tab we specify: Content-Type as application/json
  //
  //  In the 'Body' Tab of Postman we choose 'raw'
  //
  //  Then we input this:
  //
  // { "id" : "7" }
  //
  //  Upon sending in Postman we get back: { "message": "Post Deleted" }
  //  And if we look at the myblog database, we will see the added post.
  //
  //
  //////////////////////////////////////////////////////////////////////////////


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


  //Set ID to update
  $post->id = $data->id;


  //Delete post
  if($post->delete()) {
    echo json_encode( array('message' => 'Post Deleted') );
  } else {
    echo json_encode( array('message' => 'Post Not Deleted') );
  }
