<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/Category.php';


  $database       = new Database();                                //Instantiate new Database
  $db             = $database->connect();                          //Establish connection
  $category       = new Category($db);                             //Instantiate blog post object
  $data           = json_decode(file_get_contents("php://input")); //Get raw posted data

  $category->id   = $data->id;                                     //Set id to UPDATE
  $category->name = $data->name;


  //Update post
  if($category->update()) {
    echo json_encode( array('message' => 'Category Updated') );
  } else {
    echo json_encode( array('message' => 'Category not updated') );
  }
