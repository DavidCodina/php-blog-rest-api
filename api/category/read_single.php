<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');


  include_once '../../config/Database.php';
  include_once '../../models/Category.php';


  $database       = new Database();                            //Instantiate new Database
  $db             = $database->connect();                      //Establish connection
  $category       = new Category($db);                         //Instantiate blog category object
  $category->id   = isset($_GET['id']) ? $_GET['id'] : die();  //Get ID


  //Get post
  $category->read_single();


  //Create array
  $category_arr = array('id' => $category->id, 'name' => $category->name);

  //Make JSON
  print_r(json_encode($category_arr));
