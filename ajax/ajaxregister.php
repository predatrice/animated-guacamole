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
    $emailcheck = $account -> checkIfEmailExists($email);
    if($emailcheck === true){
      //email exists
      $response["success"] = false;
    }
    else{
      //email does not exist
      $response["success"] = true;
    }
    echo json_encode($response);
  }
  if($_POST["action"] == "register"){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    if($account -> register($username, $email, $password1, $password2)){
      //registration successful
      $response["success"] = true;
    }
    else{
      $response["success"] = false;
      $response["errors"] = implode(" ",$account -> getErrors());
    }
    echo json_encode($response);
  }
}
?>