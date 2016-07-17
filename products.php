<?php
/**
 * Created by PhpStorm.
 * User: jhinchley
 * Date: 7/17/16
 * Time: 2:16 PM
 */

// connect to database
include 'config/database.php';

// page headers
$page_title="Products";
include 'layout_head.php';

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "1";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "1";

// show message
if($action=='added'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> added to your cart!";
    echo "</div>";
}

else if($action=='failed'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> failed to add to your cart!";
    echo "</div>";
}

// select products from database
$query = "SELECT p.id, p.name, p.price, ci.quantity 
        FROM products p 
        LEFT JOIN cart_items ci
        ON p.id = ci.product_id 
        ORDER BY p.name";

try {
    $stmt = $db->prepare($query);
    $result=$stmt->execute();
    // count number of products returned
    $num = $stmt->rowCount();
}
catch (PDOException $e) {
    // Note: On a production website, you should not output $ex->getMessage().
    // It may provide an attacker with helpful information about your code.
    die("Failed to run query: " );//. $ex->getMessage()
}

if($num>0){

    //start table
    echo "<table class='table table-hover table-responsive table-bordered'>";

        // our table heading
        echo "<tr>";
            echo "<th class='textAlignLeft'>Product Name</th>";
            echo "<th>Price (USD)</th>";
            echo "<th style='width:5em;'>Quantity</th>";
            echo "<th>Action</th>";
        echo "</tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            //creating new table row per record
            echo "<tr>";
                echo "<td>";
                    echo "<div class='product-id' style='display:none;'>{$id}</div>";
                    echo "<div class='product-name'>{$name}</div>";
                echo "</td>";
                echo "<td>&#36;" . number_format($price, 2, '.' , ',') . "</td>";
                if(isset($quantity)){
                    echo "<td>";
                             echo "<input type='text' name='quantity' value='{$quantity}' disabled class='form-control' />";
                    echo "</td>";
                    echo "<td>";
                        echo "<button class='btn btn-success' disabled>";
                            echo "<span class='glyphicon glyphicon-shopping-cart'></span> Added!";
                        echo "</button>";
                    echo "</td>";
                }else{
                    echo "<td>";
                             echo "<input type='number' name='quantity' value='1' class='form-control' />";
                    echo "</td>";
                    echo "<td>";
                        echo "<button class='btn btn-primary add-to-cart'>";
                            echo "<span class='glyphicon glyphicon-shopping-cart'></span> Add to cart";
                        echo "</button>";
                    echo "</td>";
                }
            echo "</tr>";
        }

    echo "</table>";
}
// tell the user if there's no products in the database
else{
    echo "No products found.";
}

include 'layout_foot.php';
?>