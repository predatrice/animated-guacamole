<?php
include("../autoloader.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $response = array();
  //check if a username exists
  $account = new Account();
  if($_POST["action"] == "checkuser"){
    $username = $_POST["username"];
    $check = $account -> checkIfUserExists($username);
    if($check == true){
      //user exists
      $response["success"] = false;
    }
    else{
      //user does not exist
      $response["success"] = true;
    }
    echo json_encode($response);
  }
  if($_POST["action"] == "checkemail"){
    $email = $_POST["email"];
    $check = $account -> checkIfEmailExists($email);
    if($check == true){
      //email exists
      $response["success"] = false;
    }
    else{
      //email does not exist
      $response["success"] = true;
    }
    echo json_encode($response);
  }
}
?>