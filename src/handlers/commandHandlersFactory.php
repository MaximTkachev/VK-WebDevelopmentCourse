<?php
require_once "commands.php";
require_once "handlers/implement/createTaskHandler.php";
require_once "handlers/implement/defaultHandler.php";
require_once "handlers/implement/doneTaskHandler.php";
require_once "handlers/implement/menuHandler.php";
require_once "handlers/implement/removeTaskHandler.php";
require_once "handlers/implement/getAllHandler.php";
require_once "handlers/implement/getUndoneHandler.php";
require_once "core/implement/defaultTaskRepository.php";
require_once "core/implement/defaultUserRepository.php";

function buildHandler($object, $mysqli): handler {
    $taskRepository = new defaultTaskRepository($mysqli);
    $userRepository = new defaultUserRepository($mysqli);

    $text = $object -> text;
    if ($text == null || $text == "") {
        return new DefaultHandler($userRepository, $taskRepository);
    }

    $command = explode(" ", $text)[0];
    if (in_array($command, CREATE_COMMANDS)) {
        $handler = new CreateTaskHandler($userRepository, $taskRepository);
    } elseif (in_array($command, DONE_COMMANDS)) {
        $handler = new DoneTaskHandler($userRepository, $taskRepository);
    } elseif (in_array($command, REMOVE_COMMANDS)) {
        $handler = new RemoveTaskHandler($userRepository, $taskRepository);
    } elseif (in_array($command, MENU_COMMANDS)) {
        $handler = new MenuHandler($userRepository, $taskRepository);
    } elseif (in_array($command, GET_ALL_COMMANDS)) {
        $handler = new getAllHandler($userRepository, $taskRepository);
    } elseif (in_array($command, GET_UNDONE_COMMANDS)) {
        $handler = new getUndoneHandler($userRepository, $taskRepository);
    }

    return $handler ?? new DefaultHandler($userRepository, $taskRepository);
}