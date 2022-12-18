<?php
require_once "core/taskRepository.php";
require_once "core/abstractRepository.php";
require_once "models/taskEntity.php";
require_once "models/createTaskDto.php";
require_once "exceptions/dbException.php";
require_once "exceptions/notFoundException.php";
require_once "exceptions/invalidArgumentsException.php";

class defaultTaskRepository extends abstractRepository implements taskRepository {

    private const REGISTER_USER = "INSERT INTO task_next_ids(user_id) VALUES (?)";

    private const INSERT = "INSERT INTO tasks(owner_id, local_id, description) VALUES (?, ?, ?)";

    private const INCREMENT_ID = "UPDATE task_next_ids SET next_id = next_id + 1  WHERE user_id = ?";

    private const GET_TASK_ID = "SELECT next_id FROM task_next_ids WHERE user_id = ?";

    private const MARK_AS_DONE = "UPDATE tasks SET current_status = 'done' WHERE owner_id = ? and local_id = ?";

    private const DELETE = "DELETE FROM tasks where owner_id = ? AND local_id = ?";

    private const SELECT_ALL_BY_OWNER_ID = "SELECT local_id, description, current_status FROM tasks WHERE owner_id = ?";

    private const SELECT_UNDONE_BY_OWNER_ID = self::SELECT_ALL_BY_OWNER_ID . " AND current_status = 'new'";

    private const SELECT_BY_ID = self::SELECT_ALL_BY_OWNER_ID . " AND local_id = ?";

    public function __construct($mysqli) {
        parent::__construct($mysqli);
    }

    public function registerUser(userEntity $userEntity): void {
        $this->executeWithIntKey(self::REGISTER_USER, $userEntity->getId());
    }

    public function getById(int $ownerId, int $id): ?taskEntity {
        $stmt = $this->executeWithTwoIntKeys(self::SELECT_BY_ID, $ownerId, $id);
        $entities = $this->fetchTasks($stmt, $ownerId);
        if (count($entities) != 0) {
            return $entities[0];
        } else {
            return null;
        }
    }

    public function save(createTaskDto $dto): int {
        $taskId = $this->generateId($dto->getOwnerId());

        $stmt = $this->mysqli->prepare(self::INSERT);
        if (!$stmt) {
            throw new dbException("bad SQL-statement", 500);
        }

        $ownerId = $dto->getOwnerId();
        $description = $dto->getDescription();
        $stmt->bind_param("iis", $ownerId, $taskId, $description);

        $res = $stmt->execute();
        if (!$res) {
            throw new dbException("error while executing SQL-statement", 500);
        }
        return $taskId;
    }

    private function generateId(int $ownerId): int {
        $this->executeWithIntKey(self::INCREMENT_ID, $ownerId);
        return $this->executeWithIntResult(self::GET_TASK_ID, $ownerId);
    }

    public function markAsDone(int $ownerId, int $id): void {
        $task = $this->getById($ownerId, $id);
        if ($task == null) {
            throw new notFoundException("задача не найдена", 404);
        }
        if ($task->getStatus() == taskStatus::DONE) {
            throw new invalidArgumentsException("задача уже выполнена", 400);
        }

        $this->executeWithTwoIntKeys(self::MARK_AS_DONE, $ownerId, $id);
    }

    public function remove(int $ownerId, int $id): void {
        $task = $this->getById($ownerId, $id);
        if ($task == null) {
            throw new notFoundException("задача не найдена", 404);
        }

        $this->executeWithTwoIntKeys(self::DELETE, $ownerId, $id);
    }

    public function getUndoneByOwnerId(int $ownerId):array {
        $stmt = $this->executeWithIntKey(self::SELECT_UNDONE_BY_OWNER_ID, $ownerId);
        return $this->fetchTasks($stmt, $ownerId);
    }

    public function getAllByOwnerId(int $ownerId): array {
        $stmt = $this->executeWithIntKey(self::SELECT_ALL_BY_OWNER_ID, $ownerId);
        return $this->fetchTasks($stmt, $ownerId);
    }

    private function fetchTasks(mysqli_stmt $stmt, int $ownerId): array {
        $stmt->bind_result($id, $description, $statusString);

        $entities = array();
        for ($i = 0; $stmt->fetch(); $i++) {
            $taskStatus = taskStatus::fromString($statusString);
            $entity = new taskEntity($ownerId, $id, $description, $taskStatus);
            $entities[$i] = $entity;
        }

        return $entities;
    }
}