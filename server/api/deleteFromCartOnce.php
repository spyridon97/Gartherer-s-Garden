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
//  allow only POST Request
$utilities->checkCorrectRequestMethod('POST');

//  instantiate database object
$database = new Database();
//  get database connection
$db = $database->getConnection();

//  get product id
$data = json_decode(file_get_contents("php://input"));

$results = array();
$results["products"] = array();
$results["quantities"] = array();

// make sure we were given an id parameter
if ($data->id > 0) {

    //  start session
    session_start();

    //  if we have previously added products to the cart
    if (isset($_SESSION["cart"])) {
        if (in_array($data->id, $_SESSION["cart"])) {
            //  find product in the array and get its key
            $key = array_search($data->id, $_SESSION["cart"]);

            //  remove only one element from the array using the key
            unset($_SESSION["cart"][$key]);

            //  set response code - 200 OK
            http_response_code(200);

            $productsController = new ProductsController($db);

            //  reading product

            //  query product
            $stmt = $productsController->getProduct($data->id);
            $num = $stmt->rowCount();
            
            //  get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            //  return product json
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
            $quantity = $tmp[$data->id];

            if($quantity!=NULL){
                array_push($results["quantities"], $quantity);
            }else{
                array_push($results["quantities"], 0);
            }
            echo json_encode($results);
            
        } else {
            //  set response code - 404 Not found
            http_response_code(404);

            //  tell the user
            echo json_encode(array("message" => "Unsuccessful deletion. ProductsController not in cart."));
        }
    } else {
        //  set response code - 404 Not found
        http_response_code(404);

        //  tell the user
        echo json_encode(array("message" => "Unable to remove from cart. Cart is empty."));
    }
} else {
    //  set response code - 400 bad request
    http_response_code(400);

    //  tell the user
    echo json_encode(array("message" => "Unable to remove from cart. Please give an id"));
}