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

