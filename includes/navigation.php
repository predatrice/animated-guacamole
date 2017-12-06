<?php
// add intelligence to the navigation bar to show links depending on 
// whether the user is logged in or not
//if user is not logged in
if(!$_SESSION["email"]){
  $navitems = array(
    "Home"=>"index.php",
    "Sign Up"=>"register.php",
    "Sign In"=>"login2.php"
    );
}
//if user is logged in
if($_SESSION["email"] && !$_SESSION["admin"]){
  $navitems = array(
    "Home"=>"index.php",
    "My Account"=>"account.php",
    "Sign Out"=>"logout.php"
    );
}
if($_SESSION["email"] && $_SESSION["admin"]){
  $navitems = array(
    "Home"=>"index.php",
    "My Account"=>"account.php",
    "Sign Out"=>"logout.php",
    "Admin" => "admin.php"
    );
}

?>
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
      <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="index.php" class="navbar-brand">Chirins Shop</a>
      <p class="navbar-text navbar-user">
        <?php
        if($_SESSION["username"]){
          echo "Hello ". $_SESSION["username"];
        }
        if($_SESSION["profile_image"]){
          $profile_image = $_SESSION["profile_image"];
          echo "<img class=\"nav-profile-image\" src=\"profile_images/$profile_image\">";
        }
        ?>
      </p>
    </div>
    <div class="collapse navbar-collapse" id="main-menu">
      <ul class="nav navbar-nav navbar-right">
        <?php
        $currentpage = basename($_SERVER["REQUEST_URI"]);
        foreach($navitems as $name=>$link){
          if($link == $currentpage){
            $active = "class=\"active\"";
          }
          else{
            $active = "";
          }
          echo "<li $active><a href=\"$link\">$name</a></li>";
        }
        ?>
        <li><a href="phpmyadmin" target="_blank" rel="noopener">Database</a></li>
      </ul>
    </div>
    
    </div>
  </nav>
</header>
<div class="container">
  <?php 
  include("includes/shopping.php"); 
  ?> 
</div>