<?php
require_once "handlers/abstractHandler.php";
require_once "handlers/commands.php";

class MenuHandler extends abstractHandler {

    protected function handleCommand($object): string {
        return $this->arrayToString(CREATE_COMMANDS) . " {описание} - создать задачу\n"
            . $this->arrayToString(DONE_COMMANDS) . " {id} - отметить задачу как выполнную\n"
            . $this->arrayToString(REMOVE_COMMANDS) . " {id} - удалить задачу\n"
            . $this->arrayToString(GET_UNDONE_COMMANDS) . " - получить список незавершенных задач\n"
            . $this->arrayToString(GET_ALL_COMMANDS) . " - получить список всех задач\n";
    }

    private function arrayToString(array $value): string {
        return implode(", ", $value);
    }
}