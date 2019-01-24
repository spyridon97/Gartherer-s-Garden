<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 6:45 μμ
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//  include database and object files
include_once '../config/Database.php';
include_once '../objects/Comment.php';

//  instantiate database object
$database = new Database();
//  get database connection
$db = $database->getConnection();

//  instantiate comment object
$comment = new Comment($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

//  make sure data are not empty
if (!empty($data->product_id) && !empty($data->comment_text) && !empty($data->stars)) {

    //  make sure stars are between 1 and 5
    if ($data->stars >= 1 && $data->stars <= 5) {

        //  set product property values
        $comment->product_id = intval($data->product_id);
        $comment->comment_text = $data->comment_text;
        $comment->stars = intval($data->stars);

        //  create the product
        if ($comment->createComment()) {
            //  set response code - 201 created
            http_response_code(201);

            //  tell the user
            echo json_encode(array("message" => "Comment was created."));

        } else {//  if unable to create the product, tell the user
            // set response code - 503 service unavailable
            http_response_code(503);

            //  tell the user
            echo json_encode(array("message" => "Unable to create comment."));
        }
    } else {
        //  set response code - 400 bad request
        http_response_code(400);

        //  tell the user
        echo json_encode(array("message" => "Unable to create comment. Stars must be between 1 and 5."));
    }
} else {//  tell the user data is incomplete

    //  set response code - 400 bad request
    http_response_code(400);

    //  tell the user
    echo json_encode(array("message" => "Unable to create comment. Data is incomplete."));
}