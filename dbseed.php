<?php
require 'bootstrap.php';

$statement = "CREATE TABLE IF NOT EXISTS items(item TEXT PRIMARY KEY, position NOT NULL";

$dbConnection->exec($statement);

?>