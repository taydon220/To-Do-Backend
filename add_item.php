<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('config.php');
    $inputjson = file_get_contents('php://input');
    $data = json_decode($inputjson, TRUE);
    $new_item = ucwords($data["item"]);
    // Confirm given position is acceptable.
    if (in_array(ucwords($data["position"]), $ACCEPTABLE_POSITIONS)) {
        $new_position = ucwords($data["position"]);
        $position_error = FALSE;
    } else {
        $position_error = TRUE;
    }
    // Check for any errors.
    if (empty($new_item) || empty($new_position) || $position_error) {
        echo "Error uploading item.";
        } else {
        $db = new SQLite3($DB_PATH);
        $statement = $db->prepare("INSERT INTO items(item, position) VALUES (?, ?)");
        $statement->bindParam(1, $new_item);
        $statement->bindParam(2, $new_position);
        $statement->execute();
        $jsonarray = array("item"=>$new_item, "position"=>$new_position);
        echo json_encode($jsonarray);
    }
}
else {
    echo "INCORRECT HTTP METHOD. SHOULD BE POST.";
}
?>