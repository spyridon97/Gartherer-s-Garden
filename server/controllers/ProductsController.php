<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 11:17 am
 */

class ProductsController
{
    //  database connection and table name
    private $conn;
    private $table_name = "products";

    //  table properties
    public $id = 'Id';
    public $name = 'Name';
    public $price = 'Price';
    public $type = 'Type';
    public $image = 'Image';
    public $quote = 'Quote';
    public $effect = 'Effect';
    public $casting_cost = 'Casting_Cost';

    /**
     * @brief ProductsController constructor.
     * @param $db ; database connection
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @brief This function returns the result of an sql query in order to get a product base on it's id.
     * @param $id : the given id
     * @return mixed : the result of the query
     */
    public function getProduct($id)
    {
        //  query
        $query = "SELECT *
                  FROM $this->table_name
                  WHERE $this->id = $id
                  LIMIT 0, 1";

        //  prepare query statement
        $stmt = $this->conn->prepare($query);
        //  execute query
        $stmt->execute();

        return $stmt;
    }

    /**
     * @brief This function returns the products with specific parameters with paging.
     * @param $type : the given type
     * @param $price_min : the given min price
     * @param $price_max ; the given max price
     * @param $casting_cost_min : the given min casting cost
     * @param $casting_cost_max : the given max casting cost
     * @param $order_by : the given order by option
     * @param $order_dir : the given direction of the order
     * @param $from_record_num : the calculated starting point in order to return results
     * @param $records_per_page : the amount of the records per page
     * @return mixed : the result of the query
     */
    public function getProducts($type, $price_min, $price_max, $casting_cost_min, $casting_cost_max,
                                $order_by, $order_dir, $from_record_num, $records_per_page)
    {
        //  sub string for query
        $type_string = ($type != "") ? "Type = '$type' AND" : "";
        //  query
        $query = "SELECT *
                  FROM  $this->table_name
                  WHERE $type_string $this->price >= $price_min AND $this->price <= $price_max AND 
                        $this->casting_cost >= $casting_cost_min AND $this->casting_cost <= $casting_cost_max
                  ORDER BY $order_by $order_dir
                  LIMIT $records_per_page OFFSET $from_record_num";

        //  prepare query statement
        $stmt = $this->conn->prepare($query);
        //  execute query
        $stmt->execute();

        return $stmt;
    }

    /**
     * @brief This function returns the products with specific parameters without paging.
     * @param $type : the given type
     * @param $price_min : the given min price
     * @param $price_max ; the given max price
     * @param $casting_cost_min : the given min casting cost
     * @param $casting_cost_max : the given max casting cost
     * @return mixed : the result of the query
     */
    public function countProducts($type, $price_min, $price_max, $casting_cost_min, $casting_cost_max)
    {
        //  sub string for query
        $type_string = ($type != "") ? "Type = '$type' AND" : "";
        //  query
        $query = "SELECT COUNT(*) as total_rows
                  FROM $this->table_name
                  WHERE $type_string $this->price >= $price_min AND $this->price <= $price_max AND 
                        $this->casting_cost >= $casting_cost_min AND $this->casting_cost <= $casting_cost_max";

        //  prepare query statement
        $stmt = $this->conn->prepare($query);
        //  execute query
        $stmt->execute();
        //  get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}