<?php
require_once "handlers/abstractHandler.php";

class RemoveTaskHandler extends abstractHandler {

    protected function handleCommand($object): string {
        $taskId = explode(" ", $object->text)[1];
        if ($taskId == null) {
            return "вы не задали идентификатор задачи";
        }

        try {
            $this->taskRepository->remove($object->peer_id, $taskId);
            return "задача успешно удалена";
        } catch (notFoundException $e) {
            return "задача с id = " . $taskId . " не существует";
        } catch (Exception $e) {
            return "небольшие проблемы с бд";
        }
    }
}