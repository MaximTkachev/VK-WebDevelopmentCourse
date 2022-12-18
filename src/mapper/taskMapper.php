<?php
require_once "models/taskEntity.php";

function map(taskEntity $taskEntity): string {
    return "№ " . $taskEntity->getId() . " [" . $taskEntity->getStatus()->toString() . "] " . $taskEntity->getDescription();
}