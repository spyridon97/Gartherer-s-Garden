<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

class Comment
{

    // database connection and table name
    private $conn;
    private $table_name = "comments";

    // object properties
    public $id = 'Id';
    public $product_id = 'Product_Id';
    public $comment_text = 'Comment_Text';
    public $stars = 'Stars';
    public $date = 'Date';

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readCommentsById($product_id, $order_by, $order_dir)
    {

        // select query
        $query = "SELECT $this->id, $this->product_id, $this->comment_text, $this->stars
                  FROM $this->table_name
                  WHERE $this->product_id = $product_id
                  ORDER BY $order_by $order_dir";

        /*// select query
        $query = "SELECT $this->id, $this->product_id, $this->comment_text, $this->stars, $this->date
                  FROM $this->table_name
                  WHERE $this->product_id = $product_id
                  ORDER BY $order_by $order_dir";*/

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}