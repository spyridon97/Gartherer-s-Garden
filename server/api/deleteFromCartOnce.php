<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// get database connection
include_once '../config/core.php';
include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

// make sure we were given an id parameter
if ($id != -1) {
    
    session_start();
    if(isset($_SESSION["cart"])){//if we have previously added products to the cart
        if(in_array($id,$_SESSION["cart"])){
            $key=array_search($id,$_SESSION["cart"]);//find product in the array and get its key
            unset($_SESSION["cart"][$key]);//remove only one element from the array using the key
            http_response_code(200);
            echo json_encode(array("message" => "Product successfully removed from cart once."));
        }else{
            http_response_code(404);
            echo json_encode(array("message" => "Unsuccessful deletion. Product not in cart."));
        }
    }else {
        http_response_code(404);
        echo json_encode(array("message" => "Unable to remove from cart. Cart is empty."));
    }
    
}else{
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to remove from cart. Please give an id"));
}