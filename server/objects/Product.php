<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

class Product
{
    //  database connection and table name
    private $conn;
    private $table_name = "products";

    //  object properties
    public $id;
    public $name;
    public $price;
    public $type;
    public $bottle_image;
    public $sprite;
    public $ad;
    public $quote;
    public $effect;
    public $casting_cost;

    //  constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProduct($id)
    {
        //  query
        $query = "SELECT *
                  FROM $this->table_name
                  WHERE Id = $id
                  LIMIT 0, 1";

        //  prepare query statement
        $stmt = $this->conn->prepare($query);
        //  execute query
        $stmt->execute();

        return $stmt;
    }

    public function getProducts($type, $price_min, $price_max, $casting_cost_min, $casting_cost_max,
                                $order_by, $order_dir, $from_record_num, $records_per_page)
    {
        //  sub string for query
        $type_string = ($type != "") ? "Type = '$type' AND" : "";
        //  query
        $query = "SELECT *
                  FROM  $this->table_name
                  WHERE $type_string Price >= $price_min AND Price <= $price_max AND 
                        Casting_Cost >= $casting_cost_min AND Casting_Cost <= $casting_cost_max
                  ORDER BY $order_by $order_dir
                  LIMIT $records_per_page OFFSET $from_record_num";

        //  prepare query statement
        $stmt = $this->conn->prepare($query);
        //  execute query
        $stmt->execute();

        return $stmt;
    }

    public function countProducts($type, $price_min, $price_max, $casting_cost_min, $casting_cost_max)
    {
        //  sub string for query
        $type_string = ($type != "") ? "Type = '$type' AND" : "";
        //  query
        $query = "SELECT COUNT(*) as total_rows
                  FROM $this->table_name
                  WHERE $type_string Price >= $price_min AND Price <= $price_max AND 
                        Casting_Cost >= $casting_cost_min AND Casting_Cost <= $casting_cost_max";

        //  prepare query statement
        $stmt = $this->conn->prepare($query);
        //  execute query
        $stmt->execute();
        //  get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}