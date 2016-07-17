<?php
/**
 * Created by PhpStorm.
 * User: jhinchley
 * Date: 7/17/16
 * Time: 2:30 PM
 * Purpose: View products in cart
 */

// connect to database
include 'config/database.php';

// page headers
$page_title="Cart";
include 'layout_head.php';

// parameters
$action = isset($_GET['action']) ? $_GET['action'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";

// display a message
if($action=='removed'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> was removed from your cart!";
    echo "</div>";
}

else if($action=='quantity_updated'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> quantity was updated!";
    echo "</div>";
}

else if($action=='failed'){
        echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> quantity failed to updated!";
    echo "</div>";
}

else if($action=='invalid_value'){
        echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> quantity is invalid!";
    echo "</div>";
}

// select products in the cart
$query="SELECT p.id, p.name, p.price, ci.quantity, ci.quantity * p.price AS subtotal  
        FROM cart_items ci  
        LEFT JOIN products p 
        ON ci.product_id = p.id";

$stmt=$db->prepare($query);
$stmt->execute();

// count number of rows returned
$num=$stmt->rowCount();

if($num>0){

    //start table
    echo "<table class='table table-hover table-responsive table-bordered'>";

    // our table heading
    echo "<tr>";
        echo "<th class='textAlignLeft'>Product Name</th>";
        echo "<th>Price (USD)</th>";
            echo "<th style='width:15em;'>Quantity</th>";
            echo "<th>Sub Total</th>";
            echo "<th>Action</th>";
    echo "</tr>";

    $total=0;

    while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        echo "<tr>";
            echo "<td>";
                        echo "<div class='product-id' style='display:none;'>{$id}</div>";
                        echo "<div class='product-name'>{$name}</div>";
            echo "</td>";
            echo "<td>&#36;" . number_format($price, 2, '.', ',') . "</td>";
            echo "<td>";
                        echo "<div class='input-group'>";
                            echo "<input type='number' name='quantity' value='{$quantity}' class='form-control'>";

                            echo "<span class='input-group-btn'>";
                                echo "<button class='btn btn-default update-quantity' type='button'>Update</button>";
                            echo "</span>";

                        echo "</div>";
                echo "</td>";
                echo "<td>&#36;" . number_format($subtotal, 2, '.', ',') . "</td>";
                echo "<td>";
            echo "<a href='remove_from_cart.php?id={$id}&name={$name}' class='btn btn-danger'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Remove from cart";
            echo "</a>";
            echo "</td>";
        echo "</tr>";

        $total += $subtotal;
    }

    echo "<tr>";
    echo "<td><b>Total</b></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td>&#36;" . number_format($total, 2, '.', ',') . "</td>";
    echo "<td>";
            echo "<a href='#' class='btn btn-success'>";
            echo "<span class='glyphicon glyphicon-shopping-cart'></span> Checkout";
            echo "</a>";
    echo "</td>";
    echo "</tr>";

    echo "</table>";
}else{
    echo "<div class='alert alert-danger'>";
    echo "<strong>No products found</strong> in your cart!";
    echo "</div>";
}


include 'layout_foot.php';
?>