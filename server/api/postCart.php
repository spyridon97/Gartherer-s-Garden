<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/Database.php';
include_once '../config/core.php';

$database = new Database();
$db = $database->getConnection();

// make sure we are given an id for the product
if ($id != -1) {
    session_start();
    //if cart array already exists in session we push the id, otherwise we also create the array
    if(isset($_SESSION["cart"])){
        array_push($_SESSION["cart"], $id);
    }else {
        $_SESSION["cart"]=array($id);
    }
    http_response_code(200);
    echo json_encode(array("message" => "Product successfully added to cart."));
}else {
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to add to cart. Please give an id."));
}