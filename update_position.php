<?php

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    include('config.php');
    $inputjson = file_get_contents('php://input');
    $data = json_decode($inputjson, TRUE);
    $target_item = ucwords($data["item"]);
    if (in_array(ucwords($data["position"]), $ACCEPTABLE_POSITIONS)) {
        $new_position = ucwords($data["position"]);
        $position_error = FALSE;
    } else {
        $position_error = TRUE;
    }
    // Check for errors.
    if (empty($target_item) || empty($new_position) || $position_error) {
        echo "Error uploading item.";
        } else {
        $db = new SQLite3($DB_PATH);
        $statement = $db->prepare("UPDATE items set position=? WHERE item=?");
        $statement->bindParam(1, $new_position);
        $statement->bindParam(2, $target_item);
        $statement->execute();
        $jsonarray = array("item"=>$target_item, "position"=>$new_position);
        echo json_encode($jsonarray);
    }
} else {
    echo "INCORRECT HTTP METHOD. SHOULD BE PUT";
}

?>