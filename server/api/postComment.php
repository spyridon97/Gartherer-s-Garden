<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 6:45 μμ
 */

// required headers
header("Content-Type: application/json; charset=UTF-8");

//  includes
include_once 'apiDocumentation.php';
include_once '../controllers/CommentsController.php';

//  utilities
$utilities = new Utilities();
//  allow only POST Request
$utilities->checkCorrectRequestMethod('POST');

//  instantiate database object
$database = new Database();
//  get database connection
$db = $database->getConnection();

//  instantiate comment object
$commentController = new CommentsController($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

//  make sure data are not empty
if (!empty($data->product_id) && !empty($data->comment_text) && !empty($data->stars)) {

    //  make sure stars are between 1 and 5
    if ($data->stars >= 1 && $data->stars <= 5) {

        //  create the product
        $result = $commentController->postComment(intval($data->product_id), $data->comment_text, intval($data->stars));
        if ($result != -1) {
            //  query last added comment
            $stmt = $commentController->getComment($result);
            $num = $stmt->rowCount();

            if ($num == 1) {
                //  get retrieved row
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $comment_item = array(
                    "id" => intval($row['Id']),
                    "product_id" => intval($row['Product_Id']),
                    "comment_text" => html_entity_decode($row['Comment_Text']),
                    "stars" => intval($row['Stars']),
                    "date" => html_entity_decode($row['Date'])
                );

                //  set response code - 201 OK
                http_response_code(201);

                //  make it json format
                echo json_encode($comment_item);
            } else {
                //  set response code - 404 Not found
                http_response_code(404);

                //  tell the user no comments found
                echo json_encode(array("message" => "No comment found."));
            }
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
} else {
    //  set response code - 400 bad request
    http_response_code(400);

    //  tell the user
    echo json_encode(array("message" => "Unable to create comment. Data is incomplete."));
}