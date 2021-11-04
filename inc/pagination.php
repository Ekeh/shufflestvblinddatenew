<?php
/**
 * Created by IntelliJ IDEA.
 * User: DELL
 * Date: 10/2/2021
 * Time: 11:44 AM
 */
function get_pagination($db, $table, $where, $page = 1, $pageSize = 20){
    try {

        // Find out how many items are in the table
        $total = $db->query("
        SELECT
            COUNT(*)
        FROM
            $table $where
    ")->fetchColumn();

        // How many items to list per page
        $limit = $pageSize;

        // How many pages will there be
        $pages = ceil($total / $limit);

        // Calculate the offset for the query
        $offset = ($page - 1)  * $limit;

        // Some information to display to the user
        $start = $offset + 1;
        $end = min(($offset + $limit), $total);

        // The "back" link
        $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

        // The "forward" link
        $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

        // Display the paging information
        echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';

        // Prepare the paged query
        $stmt = $db->mysqli_query("SELECT * FROM $table ORDER BY id DESC LIMIT $limit OFFSET $offset");

        // Do we have any results?
        if ($stmt->rowCount() > 0) {
            // Define how we want to fetch the results
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $iterator = new IteratorIterator($stmt);

            // Display the results
            foreach ($iterator as $row) {
                echo '<p>', $row['name'], '</p>';
            }

        } else {
            echo '<p>No results could be displayed.</p>';
        }

    } catch (Exception $e) {
        echo '<p>', $e->getMessage(), '</p>';
    }
}
