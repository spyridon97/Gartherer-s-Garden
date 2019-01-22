<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 4:56 μμ
 */


// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// connecting with database

// include database and object files
include_once '../config/core.php';
include_once '../shared/Utilities.php';
include_once '../config/Database.php';
include_once '../objects/Comment.php';

// instantiate database and comment object
$database = new Database();
$db = $database->getConnection();

if ($product_id != -1) {

    // initialize object
    $comment = new Comment($db);

    // reading comments

    // query comments
    $stmt = $comment->readComments($product_id, $order_by, $order_dir);
    $num = $stmt->rowCount();

    // check if more than 0 record found
    if ($num > 0) {
        // comments array
        $results = array();
        $results["comments"] = array();

        // retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);

            $comment_item = array(
                "id" => intval($Id),
                "product_id" => intval($Product_Id),
                "comment_text" => html_entity_decode($Comment_Text),
                "stars" => intval($Stars),
                "date" => html_entity_decode($Date)
            );
            array_push($results["comments"], $comment_item);
        }

        // set response code - 200 OK
        http_response_code(200);

        // show comments data in json format
        echo json_encode($results);

    } else {

        // set response code - 404 Not found
        http_response_code(404);

        // tell the user no comments found
        echo json_encode(
            array("message" => "No comments found.")
        );
    }
} else {
    // set response code - 422 Missing parameter
    http_response_code(422);

    echo json_encode(
        array("message" => "Missing parameter product_id.")
    );
}
