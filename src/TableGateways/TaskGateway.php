<?php
namespace Src\TableGateways;

class TaskGateway {
    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "SELECT * FROM tasks";
        $results = $this->db->query($statement);
        $tasks = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function searchForTasks($target_task)
    {
        $statement = $this->db->prepare("SELECT * FROM tasks WHERE task LIKE ?");
        if ($target_task[0] != "%" || $target_task[-1] != "%") {
            $target_task = "%".$target_task."%";
        }
        $statement->bindValue(1, $target_task);
        $results = $statement->execute();

        $tasks = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function find($target_id)
    {
        $statement = $this->db->prepare("SELECT * FROM tasks WHERE task_id=?");
        $statement->bindValue(1, $target_id);
        $results = $statement->execute();
        $tasks = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function insert(Array $input)
    {
        $statement = $this->db->prepare("INSERT INTO tasks (task, position) VALUES (:task,:position)");
        $statement->bindValue(':task', $input['task']);
        $statement->bindValue(':position', $input['position'] ?? 'Not Started');
        $results = $statement->execute();
    }

    public function updatePosition($target_id, $position) {
        $statement = $this->db->prepare("UPDATE tasks SET position = :position WHERE task_id = :target_id");
        $statement->bindValue(':position', $position);
        $statement->bindValue(':target_id', $target_id);
        $results = $statement->execute();
        return results->fetchArray(SQLITE3_ASSOC);
    }

    public function delete($target_id) {
        $statement = $this->db->prepare("DELETE FROM tasks WHERE task_id=?");
        $statement->bindValue(1, $target_id);
        $results = $statement->execute();
        return $results->fetchArray(SQLITE3_ASSOC);
    }
}
?>