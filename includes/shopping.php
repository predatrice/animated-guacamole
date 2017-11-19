<?php
// include("includes/database.php");
//get the main categories
$main_query = "SELECT category_id,category_name FROM categories WHERE parent_id = 0";

$mainstatement = $connection -> prepare($main_query);
$mainstatement -> execute();
$mainresult = $mainstatement -> get_result();
if($mainresult -> num_rows > 0){
  $main_categories = array();
  while($row = $mainresult -> fetch_assoc()){
    array_push($main_categories, $row);
  }
}
//get the child categories
$query = "SELECT t1.category_name AS category, 
t2.category_name AS subcategory,
t2.category_id AS id
FROM categories AS t1
LEFT JOIN categories AS t2 
ON t2.parent_id = t1.category_id";

$substatement = $connection -> prepare($query);
$substatement -> execute();
$subresult = $substatement -> get_result();
if($subresult -> num_rows > 0){
  $sub_categories = array();
  while($row = $subresult -> fetch_assoc()){
    array_push($sub_categories, $row);
  }
}

// foreach($main_categories as $main){
//   $category = $main["category_name"];
//   //echo "<p>category=$category</p>";
//   //find the subcategories
//   foreach($sub_categories as $sub){
//     $parent = $sub["category"];
//     $subcat = $sub["subcategory"];
//     if($parent == $category){
//       //echo "<p>subcategory=$subcat</p>";
//     }
//   }
// }

?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Categories</a>
      </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">      
      <?php
      foreach($main_categories as $main){
        $category = $main["category_name"];
        //find if this category has children
        $haschildren = false;
        foreach($sub_categories as $sub){
          $parent = $sub["category"];
          $subcat = $sub["subcategory"];
          if($parent == $category){
            $haschildren = true;
          }
        }
        if($haschildren==true){
          $dropdown_class = "dropdown";
          $link_attribute = "class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\"";
          $caret = "<span class=\"caret\"></span>";
        }
        else{
          $dropdown_class = "";
          $link_attribute = "";
          $caret ="";
        }
        echo "<li class=\"$dropdown_class\">
                <a href=\"#\" $link_attribute >$category $caret</a>";
        if($haschildren == true){
          echo "<ul class=\"dropdown-menu\">";
          foreach($sub_categories as $sub){
            $cat_id = $sub["id"];
            $parent = $sub["category"];
            $subcat = $sub["subcategory"];
            if($parent == $category){
              echo "<li><a href=\"index.php?category=$cat_id&page=1\">$subcat</a></li>";
            }
          }
          echo "</ul>";
        }
        echo "</li>";
      }
      ?>
           
      </ul>
         
      <div class=" text-right navbar-right">
          <a href="shopping_cart.php" class="navbar-text">
          <span class="glyphicon glyphicon-shopping-cart"></span>
          <span class="badge">2</span>
          </a>
          </div>
          <div class=" text-right navbar-right">
          <a href="wishlist.php" class="navbar-text">
             <?php 
              //get total of wishlist items
              if($_SESSION["id"]){
                $user_id = $_SESSION["id"];
                $wish = new WishList($user_id);
                $wish_count = $wish -> getCount();
              }
              ?>
            <span class="glyphicon glyphicon-heart"></span>
            <span class="badge wish-count"><?php if($wish_count){echo $wish_count;}?></span>
          </a>
          </div>
        <form class="navbar-form navbar-right" id="search-form" method="get" action="search.php">
        <div class="form-group">
          <input type="text" class="form-control" name="search-query" placeholder="Search">
          </div>
            <button type="submit" class="btn btn-default">Search</button>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
