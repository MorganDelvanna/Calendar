<?php
require_once 'functions.php';


if (!$mysqli->multi_query("CALL getEventsByMonth(-1)")) {
    echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

do {
    if ($res = $mysqli->store_result()) {
        $rows = array();
        while($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        $res->free();
    } else {
        if ($mysqli->errno) {
            echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
    }
} while ($mysqli->more_results() && $mysqli->next_result());

print json_encode($rows);
?>

