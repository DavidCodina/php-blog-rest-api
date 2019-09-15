<?php
  //////////////////////////////////////////////////////////////////////////////
  //
  //   @32:00 (of first video) we tested on Postman using:
  //   http://localhost/php_rest_myblog/api/post/read.php
  //   We get back the following JSON:
  //
  //     [
  //       {
  //           "id":            "1",
  //           "title":         "Technology Post One",
  //           "body":          "Lorem ipsum dolor sit amet, consectetur adipiscing elit... ",
  //           "author":        "Sam Smith",
  //           "category_id":   "1",
  //           "category_name": "Technology"
  //       },
  //
  //       ...
  //     ]
  //
  //////////////////////////////////////////////////////////////////////////////


  //Headers
  //@20:50
  //Since this is a rest API that we will be accessing through http, we need to
  //add a couple of headers.
  header('Access-Control-Allow-Origin: *'); //Using '*' makes this a completely public API.
  header('Content-Type: application/json'); //Accept JSON


  include_once '../../config/Database.php'; //include the Database.php file.
  include_once '../../models/Post.php';     //include the Post.php file (Post model).


  $database = new Database();         //Instantiate new Database
  $db       = $database->connect();   //Establish connection
  $post     = new Post($db);          //Instantiate blog post object
  $result   = $post->read();          //Blog post query. This returns a $stmt containing all results of the query.
  $num      = $result->rowCount();    //Get row count

  //////////////////////////////////////////////////////////////////////////////
  //
  //  Check if there are any posts.
  //  If $result contained any records, then $result->rowCount() will represent.
  //  a number greater than 0. Therefore $num will also be greater than 0.
  //  In such cases we execute the code block.
  //
  //  In the following code block we create an array of posts.
  //  This array will itself hold multiple sub arrays.
  //  Each of those sub arrays will be a row (i.e., record) from that $result set.
  //
  //  We use a while loop to loop through each result in the $result array.
  //  Then we create the $post_item array, and push it to the $posts_arr.
  //
  //  Finally, we echo json_encode($posts_arr);
  //  In other words, we respond back with a data array containing all records obtained
  //  from the request.
  //
  //////////////////////////////////////////////////////////////////////////////


  if ($num > 0) {
    $posts_arr         = array();

    ////////////////////////////////////////////////////////////////////////////
    //
    //  $posts_arr['data'] = array();
    //  Was initially commented out.
    //  However, it is an alternate implementation that gives the $posts_arr a little
    //  more flexibility just in case we want to add other things besides the data.
    //  (i.e., pagination stuff, version info, etc.).
    //
    //  Note: this entails also modifying the last line of the while loop below:
    //
    //       array_push($posts_arr['data'], $post_item);
    //
    ////////////////////////////////////////////////////////////////////////////


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      ////////////////////////////////////////////////////////////////////////////
      //
      //  extract($row);
      //
      //  Import variables into the current symbol table from an array.
      //  The extract() function does array to variable conversion.
      //  That is it converts array keys into variable names and array values into variable value.
      //  In other words, we can say that the extract() function imports variables
      //  from an array to the symbol table.
      //
      //  The keys in the input array will become the variable names and their values
      //  will be assigned to corresponding variables.
      //
      //  The return value of extract() function is an integer and it represents
      //  the number of variables successfully extracted or imported from the array.
      //
      //  As opposed to accessing with $row['id'], $row['title'], etc.
      //
      //////////////////////////////////////////////////////////////////////////////
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
  }


  //else there are no Posts...
  //Simply respond back with a an associative array containing a 'message'
  else {
    echo json_encode( array('message' => 'No Posts Found') );
  } //End of if ... else
