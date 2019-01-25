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

    public function getComment($id)
    {
        //  query to get the last id
        $query_last_id = "SELECT * 
                          FROM $this->table_name 
                          WHERE Id = $id
                          LIMIT 0, 1";

        $stmt = $this->conn->prepare($query_last_id);

        $stmt->execute();

        return $stmt;
    }

    public function getComments($product_id, $order_by, $order_dir)
    {
        //  select query
        $query = "SELECT *
                  FROM $this->table_name
                  WHERE Product_Id = $product_id
                  ORDER BY $order_by $order_dir";

        //  prepare query statement
        $stmt = $this->conn->prepare($query);
        //  execute query
        $stmt->execute();

        return $stmt;
    }

    public function postComment()
    {
        //  query to insert record
        $query = "INSERT INTO $this->table_name (Product_Id, Comment_Text, Stars, Date)
                  VALUES ($this->product_id, '$this->comment_text', $this->stars, CURDATE())";

        //  prepare query
        $stmt = $this->conn->prepare($query);

        //  execute query
        return ($stmt->execute()) ? intval($this->conn->lastInsertId()) : -1;
    }
}