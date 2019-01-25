<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

class CommentsController
{
    //  database connection and table name
    private $conn;
    private $table_name = "comments";

    //  table properties
    public $id = 'Id';
    public $product_id = 'Product_Id';
    public $comment_text = 'Comment_Text';
    public $stars = 'Stars';
    public $date = 'Date';

    /**
     * @brief Comments constructor.
     * @param $db : database connection
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @brief This function returns the comment with a specific id.
     * @param $id : the given id of the comment that we are searching for
     * @return mixed : the result of the query
     */
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

    /**
     * @brief This function returns the comments of a specific product.
     * @param $product_id : the given product_id
     * @param $order_by : the given order by option
     * @param $order_dir : the given direction of the order
     * @return mixed : the result of the query
     */
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

    /**
     * @brief This function returns the id of the comment that we posted.
     * @param $product_id : the given product_id
     * @param $comment_text : the given comment text
     * @param $stars : the given stars
     * @return int : the id of the comment that we posted
     */
    public function postComment($product_id, $comment_text, $stars)
    {
        //  query to insert record
        $query = "INSERT INTO $this->table_name (Product_Id, Comment_Text, Stars, Date)
                  VALUES ($product_id, '$comment_text', $stars, CURDATE())";

        //  prepare query
        $stmt = $this->conn->prepare($query);

        //  execute query
        return ($stmt->execute()) ? intval($this->conn->lastInsertId()) : -1;
    }
}