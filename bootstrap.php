<?php
// Autoloads php classes from src directory.
// Loads environment variables from .env file and loads using DotEnv.
// Creates connection to database using DatabaseConnector class.

require 'vendor/autoload.php';
use Dotenv\Dotenv;

use Src\System\DatabaseConnector;

$dotenv = new DotEnv(__DIR__);
$dotenv->load();

$dbConnection = (new DatabaseConnector())->getConnection();
?>