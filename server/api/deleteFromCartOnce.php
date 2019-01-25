<?php
/**
 * Created by PhpStorm.
 * User: Giannis
 * Date: 21/1/2019
 * Time: 4:56 μμ
 */

// required headers
header("Content-Type: application/json; charset=UTF-8");

//   allow only post request
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //  tell the user
    echo json_encode(array("message" => "{$_SERVER['REQUEST_METHOD']} Method Not Allowed."));

    //  set response code - 405 Method not allowed
    http_response_code(405);
    exit();
}

//  include database and object files
include_once 'apiDocumentation.php';
include_once '../config/Database.php';

//  instantiate database object
$database = new Database();
//  get database connection
$db = $database->getConnection();

//  get product id
$data = json_decode(file_get_contents("php://input"));

// make sure we were given an id parameter
if ($data->id > 0) {

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

            //  tell the user
            echo json_encode(array("message" => "Product successfully removed from cart once."));

        } else {
            //  set response code - 404 Not found
            http_response_code(404);

            //  tell the user
            echo json_encode(array("message" => "Unsuccessful deletion. Product not in cart."));
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