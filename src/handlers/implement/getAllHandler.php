<?php
require_once "handlers/abstractHandler.php";
require_once "mapper/taskMapper.php";

class getAllHandler extends abstractHandler {

    protected function handleCommand($object): string {
        try {
            $entities = $this->taskRepository->getAllByOwnerId($object->peer_id);
            if (count($entities) == 0) {
                return "задач пока нет";
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