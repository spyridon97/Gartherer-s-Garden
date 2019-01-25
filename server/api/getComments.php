<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 4:56 μμ
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
include_once '../objects/Comment.php';

//  instantiate database object
$database = new Database();
//  connecting with database
$db = $database->getConnection();

if ($product_id > 0) {
    //  initialize comment object
    $comment = new Comment($db);

    //  reading comments

    //  query comments
    $stmt = $comment->getComments($product_id, $order_by, $order_dir);
    $num = $stmt->rowCount();

    //  check if more than 0 record found
    if ($num > 0) {
        //  comments array
        $results = array();
        $results["comments"] = array();

        //  retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comment_item = array(
                "id" => intval($row['Id']),
                "product_id" => intval($row['Product_Id']),
                "comment_text" => html_entity_decode($row['Comment_Text']),
                "stars" => intval($row['Stars']),
                "date" => html_entity_decode($row['Date'])
            );
            array_push($results["comments"], $comment_item);
        }

        //  set response code - 200 OK
        http_response_code(200);

        //  show comments data in json format
        echo json_encode($results);

    } else {
        //  set response code - 404 Not found
        http_response_code(404);

        //  tell the user no comments found
        echo json_encode(array("message" => "No comments found."));
    }
} else {
    //  set response code - 422 Missing parameter
    http_response_code(422);

    echo json_encode(array("message" => "Missing parameter product_id."));
}
