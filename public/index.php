<?php
require "../bootstrap.php";
use Src\Controller\TaskController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// all of our endpoints start with /task
// everything else results in a 404 Not Found
if ($uri[1] !== 'task') {
    header("HTTP/1.1 404 Not Found");
    exit();
}


$taskId = null;
$taskSearchString = null;
if (isset($uri[2])) {
    switch ($uri[2]) {
        case 'id':
            // Endpoint /task/id/{taskId}
            if (isset($uri[3])) {
                $taskId = (int) $uri[3];
            }
            break;
        default:
            // Endpoint /task/{taskSearchString}
            $taskSearchString = $uri[2];
            break;
    }
}

// Endpoint /task means both taskId and taskSearchString are null when passed to TaskController and will return all tasks.

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and task ID to the TaskController and process the HTTP request:
$controller = new TaskController($dbConnection, $requestMethod, $taskId, $taskSearchString);
$controller->processRequest();

?>