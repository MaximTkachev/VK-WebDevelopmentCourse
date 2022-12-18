<?php
require_once "handlers/abstractHandler.php";

class DefaultHandler extends abstractHandler {

    protected function handleCommand($object): string {
        return "Получена неизвестная команда\n"
        . "Введите /menu, чтобы получить список доступных комманд";
    }
}