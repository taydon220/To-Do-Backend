<?php

include('config.php');

$db = new SQLite3($DB_PATH);

$results = $db->query("SELECT item,position FROM items");
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $jsonArray[] = $row;
}
echo json_encode($jsonArray);
?>
