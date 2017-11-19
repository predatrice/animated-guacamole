<?php
//unset session variables
//to access session, it needs to be started
session_start();
//unset variables
unset($_SESSION["username"]);
unset($_SESSION["email"]);
unset($_SESSION["profile_image"]);
unset($_SESSION["admin"]);
unset($_SESSION["id"]);

//redicrect user to home page
header("location: index.php");
?>