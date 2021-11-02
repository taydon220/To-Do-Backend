<?php
namespace Src\System;

class DatabaseConnector {

    private $dbConnection = null;

    public function __construct()
    {
        $path = getenv('DB_PATH');
        $this->dbConnection = new SQLite3($path);
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}
?>