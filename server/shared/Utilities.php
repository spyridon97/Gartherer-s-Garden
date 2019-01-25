<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 3:40 μμ
 */

class Utilities
{
    /**
     * @brief This function helps with the paging of the results of the products.
     * @param $page : the current page.
     * @param $total_rows : the total result of the query without the pagination
     * @param $records_per_page : the amount of records per page
     * @return array : the json style paging information that we need
     */
    public function getPaging($page, $total_rows, $records_per_page)
    {
        //  count all products in the database to calculate total pages
        $total_pages = ceil($total_rows / $records_per_page);

        $paging_arr[] = array();
        $page_count = 0;

        for ($x = 1; $x <= $total_pages; $x++) {
            if (($x > 0) && ($x <= $total_pages)) {
                $paging_arr[$page_count]["page"] = $x;
                $paging_arr[$page_count]["current_page"] = $x == $page ? "yes" : "no";
                $page_count++;
            }
        }

        // json format
        return $paging_arr;
    }

    /**
     * @brief This function check if the request method was correct.
     * @param $correctMethod : is the correct method that must be used
     */
    public function checkCorrectRequestMethod($correctMethod)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != $correctMethod) {
            //  tell the user
            echo json_encode(array("message" => "$method Method is not allowed. Use only $correctMethod."));

            //  set response code - 405 Method not allowed
            http_response_code(405);
            exit();
        }
    }
}