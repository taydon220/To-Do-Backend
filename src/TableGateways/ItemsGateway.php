<?php
namespace Src\TableGateways;

class itemsGateway {
    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "SELECT item,position FROM items";
        $results = $this->db->query($statement);
        return $results->fetchArray(SQLITE3_ASSOC);
    }

    public function find($target_item)
    {
        $statement = $this->db->prepare("SELECT position FROM items WHERE item = ?");
        $statement->bindValue(1, $target_item);
        $results = $statement->execute();
        return $results->fetchArray(SQLITE3_ASSOC);
    }
}
?>