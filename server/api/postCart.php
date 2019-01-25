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

// get posted data
$data = json_decode(file_get_contents("php://input"));

$results = array();
$results["products"] = array();
$results["quantities"] = array();

//  make sure data are not empty
if (!empty($data->id)) {

    //  make sure we were given an id parameter
    if ($data->id > 0) {
        session_start();

        //  if cart array already exists in session we push the id, otherwise we also create the array
        if (isset($_SESSION["cart"])) {
            array_push($_SESSION["cart"], $data->id);
        } else {
            $_SESSION["cart"] = array($data->id);
        }

        //  set response code - 200 OK
        http_response_code(200);

        //  show products data in json format
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

            array_push($results["quantities"], $quantity);
            
            echo json_encode($results);
    } else {
        //  set response code - 400 bad request
        http_response_code(400);

        //  tell the user
        echo json_encode(array("message" => "Unable to add to cart. Please give correct id."));
    }
} else {
    //  set response code - 400 bad request
    http_response_code(400);

    //  tell the user
    echo json_encode(array("message" => "Unable to add to cart. Please give an id."));
}