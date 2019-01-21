<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

class Product
{
    // database connection and table name
    private $conn;
    private $table_name = "products";

    // object properties
    public $id = "Id";
    public $name = "Name";
    public $price = "Price";
    public $bottle_image = "Bottle_Image";
    public $sprite = "Sprite";
    public $ad = "Ad";
    public $quote = "Quote";
    public $effect = "Effect";
    public $casting_cost = "Casting_Cost";

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readProducts($price_min, $price_max, $casting_cost_min, $casting_cost_max,
                                 $order_by, $order_dir, $from_record_num, $records_per_page)
    {
        // query
        $query = "SELECT $this->id, $this->name, $this->price, Image, $this->quote, $this->effect, $this->casting_cost
                  FROM $this->table_name
                  WHERE $this->price >= $price_min AND $this->price <= $price_max AND 
                        $this->casting_cost >= $casting_cost_min AND $this->casting_cost <= $casting_cost_max
                  ORDER BY $order_by $order_dir
                  LIMIT $records_per_page OFFSET $from_record_num";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function count($price_min, $price_max, $casting_cost_min, $casting_cost_max)
    {
        $query = "SELECT COUNT(*) as total_rows 
                  FROM $this->table_name
                  WHERE $this->price >= $price_min AND $this->price <= $price_max AND 
                        $this->casting_cost >= $casting_cost_min AND $this->casting_cost <= $casting_cost_max";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}