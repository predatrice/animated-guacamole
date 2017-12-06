<?php
session_start();
include("autoloader.php");

include("includes/database.php");

if(count($_GET) > 0){
  //construct GET parameters as string
  //to add to link to login page, in case user already has an account
  $params = array();
  foreach($_GET as $name => $value){
    $params[$name] = $value;
  }
  $url_params = http_build_query($params);
  $login_url = "login2.php" . "?" . $url_params;
}
else{
  $login_url = "login2.php";
}
?>
<!doctype html>  
<html>
<?php
$page_title = "Register For Account";
include("includes/head.php");
?>
<body>
  <?php include("includes/navigation.php"); ?>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <form id="registration" action="register.php" method="post">
          <h2>Register for an account</h2>

          <div class="form-group" data-group="username">
            <label for="username">Username</label>
            <input class="form-control" name="username" type="text" id="username" placeholder="minimum 6 characters">
            <span class="help-block" data-error="username"></span>
          </div>
          
          <div class="form-group" data-group="email">
            <label for="email">Email</label>
            <input class="form-control" name="email" type="email" id="email" placeholder="you@domain.com">
            <span class="help-block" data-error="email"></span>
          </div>
          <!--password-->
          
          <div class="form-group" data-group="password">
            <!--password 1-->
            <label for="password1">Password</label>
            <input  class="form-control" name="password1" type="password" id="password1" placeholder="minimum 8 characters">
            <!--password 2-->
            <label for="password2">Retype Password</label>
            <input  class="form-control" name="password2" type="password" id="password2" placeholder="retype password">
            <span class="help-block" data-error="password"></span>
          </div>
          <p>Have an account? <a href="<?php echo $login_url; ?>">Sign In</a></p>
          <div class="text-center">
            <button type="submit" disabled name="register" class="btn btn-default">Register</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
  <script>
    <?php
    //echo GET variables as javascript variables
      $js_vars = new GetToVars($_GET);
      echo $js_vars;
    ?>
  </script>
  <script src="js/register.js"></script>
</body>
</html>

<template id="register-template">
  <div class="alert alert-dismissable">
    <button class="close" type="button" data-dismiss="alert">
      &times;
    </button>
    <p class="message"></p>
  </div>
</template>
<template id="spinner-template">
  <span class="spinner-container">
    <img class="spinner" src="graphics/spinner.png">
  </span>
</template>
<template id="check-template">
  <span class="glyphicon glyphicon-ok">
  </span>
</template>