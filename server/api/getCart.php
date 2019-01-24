<?php
include_once '../config/Database.php';
include_once '../config/core.php';
include_once '../objects/Product.php';
include_once '../shared/Utilities.php';

//  instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$results = array();
$results["products"] = array();
$results["quantities"] = array();

$utilities = new Utilities();
$product = new Product($db);

session_start();
if(isset($_SESSION["cart"]) and $_SESSION["cart"]!=NULL){
    //for each unique id in the cart, meaning we don't show each product more than once
    foreach(array_unique($_SESSION["cart"]) as $proion){

        $stmt = $product->readProduct($proion);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        //code same with getProduct    
        
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
    
        $product_item = array(
            "id" => intval($Id),
            "name" => html_entity_decode($Name),
            "price" => intval($Price),
            "type" => html_entity_decode($Type),
            "ad" => "/images/Ads/{$Image}",
            "bottle" => "/images/Bottles/{$Image}",
            "sprite" => "/images/Sprites/{$Image}",
            "quote" => html_entity_decode($Quote),
            "effect" => html_entity_decode($Effect),
            "casting_cost" => intval($Casting_Cost)
        );
        
        array_push($results["products"], $product_item);  
        $tmp = array_count_values($_SESSION["cart"]);
        $quantity=$tmp[$proion];
    
        array_push($results["quantities"],$quantity);
    }      
    // set response code - 200 OK
    http_response_code(200);
    // make it json format
    echo json_encode($results);
}else {
    // set response code - 404 not found
    http_response_code(404);
    // tell the user
    echo json_encode(array("message" => "Cart is empty."));
}