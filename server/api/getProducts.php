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

//  initialize object
$product = new Product($db);

//  utilities
$utilities = new Utilities();

//  reading products

//  query products
$stmt = $product->readProducts($price_min, $price_max, $casting_cost_min, $casting_cost_max,
    $order_by, $order_dir, $from_record_num, $records_per_page);
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // products array
    $results = array();
    $results["products"] = array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $product_item = array(
            "id" => intval($Id),
            "name" => html_entity_decode($Name),
            "price" => intval($Price),
            "ad" => "../../images/Ads/{$Image}",
            "bottle" => "../../images/Bottles/{$Image}",
            "sprite" => "../../images/Sprites/{$Image}",
            "quote" => html_entity_decode($Quote),
            "effect" => html_entity_decode($Effect),
            "casting_cost" => intval($Casting_Cost)
        );
        array_push($results["products"], $product_item);
    }

    $total_rows = $product->count($price_min, $price_max, $casting_cost_min, $casting_cost_max);
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page);
    $results["number_of_results"] = intval($total_rows);
    $results["paging"] = $paging;

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($results);

} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}