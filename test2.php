<?php
include("autoloader.php");

//$cat = new Cat("Tabby");
//echo "Hello, myname is " . $cat -> getName();

//$db = new Database();
//$conn = $db -> getConnection();
//if($conn){
//    echo " connected";
//}

//test Account -> register()
$account = new Account();
//$registration = $account ->register("username1","user@email.com","password","password");
$login = $account -> authenticate('kylaren','12345678');
if($login){
    echo "success";
}
else{
    echo "login failed";
}
?>