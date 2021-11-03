<?php
require 'bootstrap.php';

$statement = "CREATE TABLE IF NOT EXISTS tasks(task_id INTEGER PRIMARY KEY, task TEXT NOT NULL, position TEXT DEFAULT 'Not Started')";

$dbConnection->exec($statement);

?>