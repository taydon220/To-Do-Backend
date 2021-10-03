<?php

include('config.php');

$db = new SQLite3($DB_PATH);

$new_item = "Configure php";
$new_position = $COMPLETED;

$statement = $db->prepare("INSERT INTO items(item, position) VALUES (?,?)");
$statement->bindParam(1, $new_item);
$statement->bindParam(2, $new_position);

$statement->execute();

$results = $db->query("SELECT * FROM items");

while ($row = $results->fetchArray()) {
    echo "{$row[0]} {$row[1]}\n";
}

?>