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


/** JSON example of server/api/deleteFromCart.php **/

/*
{
    "id" : 4
}
*/


/** JSON example of server/api/deleteFromCartOnce.php **/

/*
{
    "id" : 4
}
*/

/** server/api/getCart.php does not need any parameter **/


/** parameters passed through PHP URL for server/api/getComments.php **/
//  product_id is REQUIRED

//  you set the product_id of the product
$product_id = isset($_GET["product_id"]) ? $_GET["product_id"] : -1;
//  you set the ordering column e.g. Date, Stars, Id,
$order_by = isset($_GET["order_by"]) ? $_GET["order_by"] : "Id";
//  you set the ordering direction e.g. ASC, DESC
$order_dir = isset($_GET["order_dir"]) ? $_GET["order_dir"] : "ASC";


/** parameters passed through PHP URL for server/api/getProduct.php **/
//  id is REQUIRED

//  you set the id of the product e.g. 1
$id = isset($_GET["id"]) ? $_GET["id"] : -1;


/** parameters passed through PHP URL for server/api/getProducts.php **/

//  you set the type e.g. Plasmid, Gene Tonic,
$type = isset($_GET["type"]) ? $_GET["type"] : "";
//  you set the minimum price of the product e.g. 10
$price_min = isset($_GET["price_min"]) ? $_GET["price_min"] : 0;
//  you set the maximum price of the product e.g. 200
$price_max = isset($_GET["price_max"]) ? $_GET["price_max"] : 2147483647;
//  you set the ordering column e.g. Price, Name, Casting_Cost, Id
$order_by = isset($_GET["order_by"]) ? $_GET["order_by"] : "Id";
//  you set the ordering direction e.g. ASC, DESC
$order_dir = isset($_GET["order_dir"]) ? $_GET["order_dir"] : "ASC";
//  you set the minimum casting_cost of the product e.g. 10
$casting_cost_min = isset($_GET["casting_cost_min"]) ? $_GET["casting_cost_min"] : 0;
//  you set the maximum casting_cost of the product e.g. 450
$casting_cost_max = isset($_GET["casting_cost_max"]) ? $_GET["casting_cost_max"] : 2147483647;
//  you set the page of the results e.g. 2
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

//  variables for paging the results

//  set number of records per page
$records_per_page = 10;
//  calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;


/** JSON example of server/api/postCart.php **/

/*
{
    "id" : 4
}
*/


/** JSON example of server/api/postComment.php **/

/*
{
    "product_id": 3,
    "comment_text": "Σκουπίδι",
    "stars": 5
}
*/