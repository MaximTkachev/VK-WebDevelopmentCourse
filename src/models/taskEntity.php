<?php
require_once "taskStatus.php";

class taskEntity {

    private int $ownerId;

    private int $id;

    private string $description;

    private taskStatus $status;

    public function __construct($ownerId, $id, $description, $status) {
        $this->ownerId = $ownerId;
        $this->id = $id;
        $this->description = $description;
        $this->status = $status;
    }

    public function getOwnerId(): int {
        return $this->ownerId;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getStatus(): taskStatus {
        return $this->status;
    }
}