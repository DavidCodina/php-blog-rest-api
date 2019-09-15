<?php
  //Headers
  header('Access-Control-Allow-Origin: *'); //Using '*' makes this a completely public API.
  header('Content-Type: application/json'); //Accept JSON


  include_once '../../config/Database.php'; //include the Database.php file.
  include_once '../../models/Post.php';     //include the Post.php file (Post model).


  $database = new Database();         //Instantiate new Database
  $db       = $database->connect();   //Establish connection
  $post     = new Post($db);          //Instantiate blog post object
  $result   = $post->read();          //Blog post query. This returns a $stmt containing all results of the query.
  $num      = $result->rowCount();    //Get row count


  if ($num > 0) {
    $posts_arr         = array();

    ////////////////////////////////////////////////////////////////////////////
    //
    //  $posts_arr['data'] = array();  is an alternate implementation that gives
    //  the $posts_arr a little more flexibility just in case we want to add other
    //  things besides the data. (i.e., pagination stuff, version info, etc.).
    //
    //  Note: this entails also modifying the last line of the while loop below:
    //
    //       array_push($posts_arr['data'], $post_item);
    //
    ////////////////////////////////////////////////////////////////////////////


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'id'            => $id,
        'title'         => $title,
        //Usually in a Blog the body is allowed to have HTML.
        //For that reason, we will wrap $body in html_entity_decode().
        //Presumably, we will encode it elsewhere in this app.
        'body'          => html_entity_decode($body),
        'author'        => $author,
        'category_id'   => $category_id,
        'category_name' => $category_name
      );

      array_push($posts_arr, $post_item);           //Push to $posts_arr
      //array_push($posts_arr['data'], $post_item); //Push to "data"
    }

    echo json_encode($posts_arr); //Convert to JSON & output.
  } else {
    echo json_encode( array('message' => 'No Posts Found') );
  }
