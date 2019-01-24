<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

class Comment
{
    //  database connection and table name
    private $conn;
    private $table_name = "comments";

    //  object properties
    public $id;
    public $product_id;
    public $comment_text;
    public $stars;
    public $date;

    //  constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readComments($product_id, $order_by, $order_dir)
    {
        //  select query
        $query = "SELECT Id, Product_Id, Comment_Text, Stars, Date
                  FROM $this->table_name
                  WHERE Product_Id = $product_id
                  ORDER BY $order_by $order_dir";

        //  prepare query statement
        $stmt = $this->conn->prepare($query);
        //  execute query
        $stmt->execute();

        return $stmt;
    }

    public function createComment()
    {
        //  query to insert record
        $query = "INSERT INTO $this->table_name (Product_Id, Comment_Text, Stars, Date)
                  VALUES ($this->product_id, '$this->comment_text', $this->stars, CURDATE())";

        //  prepare query
        $stmt = $this->conn->prepare($query);
        //  execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}