<?php
namespace Src\Controller;

use Src\TableGateways\TaskGateway;

// Class to process different HTTP request methods for the tasks table.
class TaskController {

    private $db;
    private $requestMethod;
    private $taskId;
    private $taskSearchString;

    private $taskGateway;

    public function __construct($db, $requestMethod, $taskId, $taskSearchString)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->taskId = $taskId;
        $this->taskSearchString = $taskSearchString;

        $this->taskGateway = new TaskGateway($db);
    }

    public function processRequest() 
    {
        switch($this->requestMethod) {
            case 'GET':
                if ($this->taskId) {
                    $response = $this->getTask($this->taskId);
                } else if ($this->taskSearchString) {
                    $response = $this->getMatchingTasks($this->taskSearchString);
                } else {
                    $response = $this->getAllTasks();
                }
                break;
            case 'POST':
                $response = $this->createTaskFromRequest();
                break;
            case 'PUT':
                $response = $this->updateTaskFromRequest($this->taskId);  // updateTaskFromRequest() needs implemented.
                break;
            // Issue with using 'DELETE' in this editor? Flags as keyword
            case 'DELETE':
                $response = $this->deleteTask($this->taskId);  // deleteTask() needs implemented.
                break;    
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllTasks()
    {
        $result = $this->taskGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getTask($id) 
    {
        $result = $this->taskGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getMatchingTasks($searchString)
    {
        $result = $this->taskGateway->searchForTasks($searchString);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createTaskFromRequest() 
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $this->taskGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = 'No results found.';
        return $response;
    }
}

?>