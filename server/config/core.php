<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

//  show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//  the home page url
//  $home_url = "http://localhost/";

/**  parameters passed through PHP URL for api/getProducts.php **/

//  you set the minimum price of the product
$price_min = isset($_GET["price_min"]) ? $_GET["price_min"] : 0;
//  you set the maximum price of the product
$price_max = isset($_GET["price_max"]) ? $_GET["price_max"] : 2147483647;
//  you set the ordering column e.g. Price, Name, Casting_Cost, Id
$order_by = isset($_GET["order_by"]) ? $_GET["order_by"] : "Id";
//  you set the ordering direction e.g. ASC, DESC
$order_dir = isset($_GET["order_dir"]) ? $_GET["order_dir"] : "ASC";
//  you set the minimum casting_cost of the product
$casting_cost_min = isset($_GET["casting_cost_min"]) ? $_GET["casting_cost_min"] : 0;
//  you set the maximum casting_cost of the product
$casting_cost_max = isset($_GET["casting_cost_max"]) ? $_GET["casting_cost_max"] : 2147483647;
//  you set the page of the results
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

//  set number of records per page
$records_per_page = 10;
//  calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;


/**  parameters passed through PHP URL for api/getComments.php **/
//  product_id is REQUIRED

//  you set the product_id of the product
$product_id = isset($_GET["product_id"]) ? $_GET["product_id"] : -1;
//  you set the ordering column e.g. Date, Stars, Id,
$order_by = isset($_GET["order_by"]) ? $_GET["order_by"] : "Id";
//  you set the ordering direction e.g. ASC, DESC
$order_dir = isset($_GET["order_dir"]) ? $_GET["order_dir"] : "ASC";

/** json example of postComment */

/*
{
    "product_id": 3,
    "comment_text": "Σκουπίδι",
    "stars": 5
}
*/