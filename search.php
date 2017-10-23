<?php
session_start();
include("includes/database.php");
//get search parameter
$keyword = $_GET["search-query"];
if(!$keyword){
  //if there is no keyword
  header("location:index.php");
}

//echo "You searched for $keyword";

//create a query to get data from database
$search_query = "SELECT 
products.id,
products.name,
products.description,
products.price,
images.image_file
FROM products
INNER JOIN products_images 
ON products.id = products_images.product_id
INNER JOIN images
ON products_images.image_id = images.image_id
WHERE products.name LIKE ? 
OR products.description LIKE ?";

//send query to database
$statement = $connection -> prepare($search_query);
//create and bind parameters
$search_term = "%".$keyword."%";
$statement -> bind_param("ss",$search_term,$search_term);
//execute the query
if( $statement -> execute() ){
  $result = $statement -> get_result();
}
else{
  //error executing query
}
?>

<!doctype html>
<html>
  <?php
  $page_title = "Search results for ".$keyword;
  include("includes/head.php");
  ?>
  <body>
    <?php include("includes/navigation.php"); ?>    
    <div class="container">
      <?php
      if( $result -> num_rows > 0){
          //tell the user hpw many items in result
        $total = $result -> num_rows;
        echo "<div class=\"row\">
        <div class=\"col-md-12\">
            <h4>Your search for $keyword returned $total results</h4>
        </div>
        </div>";
        $counter = 0;
        while($row = $result -> fetch_assoc() ){
          $counter++;
          if($counter == 1){
            echo "<div class=\"row\">";
          }
          $id = $row["id"];
          $name = $row["name"];
          $description = $row["description"];
          $price = $row["price"];
          $image = $row["image_file"];
          
          echo "<div class=\"col-md-3\">";
          echo "<h3 class=\"product-name\">$name</h3>";
          echo "<img class=\"img-responsive\" src=\"products_images/$image\">";
          echo "<p class=\"product-description\">$description</p>";
          echo "<h4 class=\"price\">$price</h4>";
          echo "<a href=\"product_detail.php?id=$id\">Details</a>";
          echo "</div>";
          
          if($counter==4){
            echo "</div>";
            $counter=0;
          }
          
        }
      }
      else{
        echo "<div class=\"row\">
        <div class=\"col-md-12\"><h4>Your search for $keyword returned no result</h4></div>
        </div>";
      }
      ?>
    </div>
  </body>
</html>