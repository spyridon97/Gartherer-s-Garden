<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/Database.php';
include_once 'apiDocumentation.php';

//  instantiate database object
$database = new Database();
//  get database connection
$db = $database->getConnection();

// get posted data
$data = json_decode(file_get_contents("php://input"));

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
        echo json_encode(array("message" => "Product successfully added to cart."));

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