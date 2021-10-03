<?php

include('config.php');

$db = new SQLite3($DB_PATH);


$db->exec("CREATE TABLE IF NOT EXISTS items(item TEXT PRIMARY KEY,  position NOT NULL)");


?>