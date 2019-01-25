<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

//  required headers
header("Content-Type: application/json; charset=UTF-8");

//   allow only post request
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    //  tell the user
    echo json_encode(array("message" => "{$_SERVER['REQUEST_METHOD']} Method Not Allowed."));

    //  set response code - 405 Method not allowed
    http_response_code(405);
    exit();
}

//  include database and object files
include_once 'apiDocumentation.php';
include_once '../shared/Utilities.php';
include_once '../config/Database.php';
include_once '../objects/Product.php';

//  instantiate database object
$database = new Database();
//  connecting with database
$db = $database->getConnection();

if ($id > 0) {
    //  initialize product object
    $product = new Product($db);

    //  reading product

    //  query product
    $stmt = $product->getProduct($id);
    $num = $stmt->rowCount();

    if ($num == 1) {
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

        //  set response code - 200 OK
        http_response_code(200);

        //  make it json format
        echo json_encode($product_item);

    } else {
        //  set response code - 404 Not found
        http_response_code(404);

        //  tell the user no comments found
        echo json_encode(array("message" => "No product found."));
    }
} else {
    //  set response code - 422 Missing parameter id
    http_response_code(422);

    echo json_encode(array("message" => "Missing parameter id or invalid value."));
}