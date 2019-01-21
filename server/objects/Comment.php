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
    public $id;
    public $product_id;
    public $comment_text;
    public $stars;
    public $date;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readComments($product_id, $order_by, $order_dir)
    {

        // select query
        $query = "SELECT Id, Product_Id, Comment_Text, Stars
                  FROM $this->table_name
                  WHERE Product_Id = $product_id
                  ORDER BY $order_by $order_dir";

        /*       // select query
        $query = "SELECT Id, Product_Id, Comment_Text, Stars, Date
                  FROM $this->table_name
                  WHERE Product_Id = $product_id
                  ORDER BY $order_by $order_dir";*/

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function createComment()
    {
        // query to insert record
        $query = "INSERT INTO $this->table_name (Product_Id, Comment_Text, Stars)
                  VALUES ($this->product_id, $this->comment_text, $this->stars)";

        echo $query;

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->comment_text = htmlspecialchars(strip_tags($this->comment_text));
        $this->stars = htmlspecialchars(strip_tags($this->stars));
        //  $this->date = htmlspecialchars(strip_tags($this->date));

        // bind values
        $stmt->bindParam(":Product_id", $this->product_id);
        $stmt->bindParam(":Comment_Text", $this->comment_text);
        $stmt->bindParam(":Stars", $this->stars);
        //  $stmt->bindParam(":Date", $this->date);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }
}