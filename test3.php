<?php
include("includes/database.php");
//get the main categories
$main_query = "SELECT category_id,category_name FROM categories WHERE parent_id = 0";

$statement = $connection -> prepare($main_query);
$statement -> execute();
$result = $statement -> get_result();
if($result -> num_rows > 0){
  $main_categories = array();
  while($row = $result -> fetch_assoc()){
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



?>

<!doctype html>  
<html>
<?php
$page_title = "Test Categories";
include("includes/head.php");
?>
<body>
  <nav class="navbar navbar-default navbar-static-top">
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
  </nav>
</body>