<?php
require_once "handlers/abstractHandler.php";
require_once "mapper/taskMapper.php";

class getUndoneHandler extends abstractHandler {

    protected function handleCommand($object): string {
        try {
            $entities = $this->taskRepository->getUndoneByOwnerId($object->peer_id);
            if (count($entities) == 0) {
                return "невыполненных задач нет";
            } else {
                $message = "Список задач:\n";
                foreach ($entities as $entity) {
                    $message = $message . map($entity) . "\n";
                }

                return $message;
            }
        } catch (Exception $e) {
            return "небольшие проблемы с бд";
        }
    }
}