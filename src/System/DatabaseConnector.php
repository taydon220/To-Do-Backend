<?php
namespace Src\System;

// Class to connect to SQLite3 database at DB_PATH found in .env file.
class DatabaseConnector {

    private $dbConnection = null;

    public function __construct()
    {
        $path = getenv('DB_PATH');
        $this->dbConnection = new \SQLite3($path);
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}
?>