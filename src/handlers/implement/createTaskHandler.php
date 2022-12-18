<?php
require_once "handlers/abstractHandler.php";
require_once "models/createTaskDto.php";

class CreateTaskHandler extends abstractHandler {

    protected function handleCommand($object): string {
        $description = explode(" ", $object->text)[1];
        if ($description == null) {
            return "вы не задали описание задачи";
        }
        $description = preg_replace('/' . "\/c " . "/", "", $object->text, 1);
        $task = new createTaskDto($object->peer_id, $description);
        try {
            return "задача успешно сохранена. id = " . $this->taskRepository->save($task);
        } catch (Exception | TypeError $e) {
            return "небольшие проблемы с базой данных";
        }
    }
}
