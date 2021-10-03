<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include('config.php');
    $db = new SQLite3($DB_PATH);
    $item_to_search = ucwords($_GET["item"]);
    $statement = $db->prepare("SELECT position from items WHERE item = ?");
    $statement->bindValue(1, $item_to_search);
    $results = $statement->execute();
    $results_array = $results->fetchArray(SQLITE3_ASSOC);
    if ($results_array) {
        echo json_encode($results_array);
    } else {
        echo "No results found.";
    }
}
?>