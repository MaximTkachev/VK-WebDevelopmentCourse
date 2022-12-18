<?php

class createTaskDto {

    private int $ownerId;

    private string $description;

    public function __construct($ownerId, $description) {
        $this->ownerId = $ownerId;
        $this->description = $description;
    }

    public function getOwnerId(): int {
        return $this->ownerId;
    }

    public function getDescription(): string {
        return $this->description;
    }
}