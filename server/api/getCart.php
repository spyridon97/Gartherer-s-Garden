<?php
/**
 * Created by PhpStorm.
 * User: Giannis
 * Date: 21/1/2019
 * Time: 4:56 μμ
 */

// required headers
header("Content-Type: application/json; charset=UTF-8");

//  includes
include_once 'apiDocumentation.php';
include_once '../controllers/ProductsController.php';

//  utilities
$utilities = new Utilities();
//  allow only GET Request
$utilities->checkCorrectRequestMethod('GET');

//  instantiate database object
$database = new Database();
//  get database connection
$db = $database->getConnection();

$results = array();
$results["products"] = array();
$results["quantities"] = array();

//  initialize product object
$productsController = new ProductsController($db);

session_start();
if (isset($_SESSION["cart"]) and $_SESSION["cart"] != NULL) {

    //  for each unique id in the cart, meaning we don't show each product more than once
    foreach (array_unique($_SESSION["cart"]) as $proion) {
        //  query product
        $stmt = $productsController->getProduct($proion);
        //  get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $product_item = array(
            "id" => intval($row['Id']),
            "name" => html_entity_decode($row['Name']),
            "price" => intval($row['Price']),
            "type" => html_entity_decode($row['Type']),
            "ad" => (file_exists("../../images/Ads/{$row['Image']}")) ? html_entity_decode("/images/Ads/{$row['Image']}") : "",
            "bottle" => (file_exists("../../images/Bottles/{$row['Image']}")) ? html_entity_decode("/images/Bottles/{$row['Image']}") : "",
            "sprite" => (file_exists("../../images/Sprites/{$row['Image']}")) ? html_entity_decode("/images/Sprites/{$row['Image']}") : "",
            "quote" => html_entity_decode($row['Quote']),
            "effect" => html_entity_decode($row['Effect']),
            "casting_cost" => intval($row['Casting_Cost'])
        );

        array_push($results["products"], $product_item);
        $tmp = array_count_values($_SESSION["cart"]);
        $quantity = $tmp[$proion];

        array_push($results["quantities"], $quantity);
    }

    //  set response code - 200 OK
    http_response_code(200);

    //  make it json format
    echo json_encode($results);
} else {
    //  set response code - 404 not found
    http_response_code(404);

    //  tell the user
    echo json_encode(array("message" => "Cart is empty."));
}