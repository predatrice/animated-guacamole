<?php
session_start();
include("autoloader.php");
include("includes/database.php");
//check if user is admin, else redirect
if( isset($_SESSION["admin"]) === false ){
  //redirect and exit
  header("location:login2.php");
  exit();
}
//create new account instance
$account = new Account();

//handle POST request to update account
if( $_SERVER["REQUEST_METHOD"] == "POST" ){
  if( $_POST["status"] == false ){
    //get account_id
    $account_id = $_POST["account_id"];
    var_dump($account -> setAccountStatus($account_id,0));
  }
  else{
    $account_id = $_POST["account_id"];
    var_dump($account -> setAccountStatus($account_id,1));
  }
}
//create a new account instance

$users = $account -> getAllAccounts();


?>
<!doctype html>
<html>
  <?php include("includes/head.php");?>
  <body>
    <?php include("includes/navigation.php"); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a href="#accounts" aria-controls="accounts" role="tab" data-toggle="tab">Accounts</a>
            </li>
            <li role="presentation">
              <a href="#products" aria-controls="products" role="tab" data-toggle="tab">Products</a>
            </li>
            
            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
          </ul>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane " id="products">...</div>
            <div role="tabpanel" class="tab-pane active" id="accounts">
              <h2>User Accounts</h2>
              <form id="account-search">
                <div class="form-group">
                  <label for="account-search" class="sr-only">Search for a user</label>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">Search for an account</span>
                    <input type="text" name="account-search" class="form-control" placeholder="type a username or email">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </form>
              <?php
              if( count($users) > 0 ){
                foreach( $users as $useraccount){
                  $userid = $useraccount["id"];
                  $username = $useraccount["username"];
                  $useremail = $useraccount["email"];
                  $userimage = $useraccount["profile_image"];
                  $usercreated = $useraccount["created"];
                  //format the date to a more human readable format
                  //see http://php.net/manual/en/function.date.php
                  $usercreated = date_format( date_create($usercreated) ,"D d F Y g:i:s a");
                  $userlastseen = $useraccount["lastseen"];
                  $userlastseen = date_format( date_create($userlastseen) ,"D d F Y g:i:s a");
                  $userstatus = $useraccount["status"];
                  $admin = $useraccount["admin"];
                  //check for admin
                  if( isset($admin) ){
                    //disable the button for admin account
                    $disabled = "disabled";
                  }
                  else{
                    $disabled = "";
                  }
                  //check if account is active
                  if( $userstatus == true ){
                    $panel_style = "panel-default";
                    $checked = "checked";
                  }
                  else{
                    $panel_style = "panel-danger";
                    $checked = "";
                  }
                  echo "<div class=\"panel $panel_style\" data-name=\"$username\" data-email=\"$useremail\">
                  <div class=\"panel-heading\">
                    <div class=\"row\">
                      <div class=\"col-md-8\">
                        <h5>Username: $username</h5>
                      </div>
                      <div class=\"col-md-4 text-right\">
                        <form class=\"form-inline\" method=\"post\" action=\"admin.php\">
                          <div class=\"checkbox\">
                            <label>
                              <input type=\"checkbox\" name=\"status\" value=\"active\" $disabled $checked>
                              Is active
                            </label>
                          </div>
                          <button type=\"submit\" name=\"account_id\" $disabled value=\"$userid\" class=\"btn btn-default\">
                            Update
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class=\"panel-body\">
                    <div class=\"row\">
                      <div class=\"col-md-1\"><img src=\"profile_images/$userimage\"></div>
                      <div class=\"col-md-3\">
                        <h4>User name</h4>
                        <p>$username</p>
                        <h4>Email address</h4>
                        <p>$useremail</p>
                      </div>
                      <div class=\"col-md-3\">
                        <h5>Account created</h5>
                        <p>$usercreated</p>
                        <h5>Last activity</h5>
                        <p>$userlastseen</p>
                      </div>
                    </div>
                  </div>
                  </div>";
                }
              }
              ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="messages">...</div>
            <div role="tabpanel" class="tab-pane" id="settings">...</div>
          </div>
        </div>
      </div>
    </div>
    <script>
      var userpanels = [];
      $(document).ready(
        function(){
          //get an array of panels
          let panels = $(".panel");
          //count the panels
          let panelcount = panels.length;
          
          for( let i=0; i<panelcount; i++){
            let panel = panels[i];
            let user = new Object();
            user.name = $(panel).data("name");
            user.email = $(panel).data("email");
            userpanels.push(user);
          }
          $("#account-search").submit( (event) => { 
              event.preventDefault();
            } 
          );
          $("#account-search").on("input",function(event){
            console.log(event.target.value);
          });
        }
      );
    </script>
  </body>
</html>
