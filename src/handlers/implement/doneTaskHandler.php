<?php
require_once "handlers/abstractHandler.php";
require_once "exceptions/notFoundException.php";
require_once "exceptions/invalidArgumentsException.php";

class DoneTaskHandler extends abstractHandler {

    protected function handleCommand($object): string {
        $taskId = explode(" ", $object->text)[1];
        if ($taskId == null) {
            return "вы не задали идентификатор задачи";
        }

        try {
            $this->taskRepository->markAsDone($object->peer_id, $taskId);
            return "задача успешно отмечена как выполненная";
        } catch (notFoundException $e) {
            return "задачи с id = " . $taskId . " не существует";
        } catch (invalidArgumentsException $e) {
            return "задача с id = " . $taskId . " уже выполнена";
        } catch (Exception $e) {
            return "небольшие проблемы с бд";
        }
    }
}