<?php
/**
 * Created by PhpStorm.
 * User: Spiros
 * Date: 21/1/2019
 * Time: 3:40 μμ
 */

class Utilities
{
    public function getPaging($page, $total_rows, $records_per_page)
    {
        // count all products in the database to calculate total pages
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
}