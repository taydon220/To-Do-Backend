<?php

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    include('config.php');
    $db = new SQLITE3($DB_PATH);
    $inputjson = file_get_contents('php://input');
    $data = json_decode($inputjson, TRUE);
    $item_to_delete = ucwords($data["item"]);
    $statement = $db->prepare("DELETE from items where item=?",);
    $statement->bindValue(1, $item_to_delete);
    $statement->execute();
    echo "Deleted $item_to_delete";
} else {
    echo "INCORRECT HTTP METHOD. EXPECTED 'DELETE'";
}

?>