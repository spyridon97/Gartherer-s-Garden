<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// connecting with database

//  include database and object files
include_once '../config/core.php';
include_once '../shared/Utilities.php';
include_once '../config/Database.php';
include_once '../objects/Product.php';

//  instantiate database and product object
$database = new Database();
$db = $database->getConnection();


if ($id != -1) {
    //  initialize object
    $product = new Product($db);

//  reading product

//  query product
    $stmt = $product->readProduct($id);

    $num = $stmt->rowCount();

    if ($num > 0) {
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

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

        // set response code - 200 OK
        http_response_code(200);

        // make it json format
        echo json_encode($product_item);

    } else {

        // set response code - 404 Not found
        http_response_code(404);

        // tell the user no comments found
        echo json_encode(
            array("message" => "No product found.")
        );
    }

} else {
    // set response code - 422 Missing parameter
    http_response_code(422);

    echo json_encode(
        array("message" => "Missing parameter id.")
    );
}