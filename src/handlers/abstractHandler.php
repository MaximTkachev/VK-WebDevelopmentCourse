<?php
require_once "handlers/handler.php";
require_once "core/userRepository.php";

abstract class abstractHandler implements handler {

    protected userRepository $userRepository;

    protected taskRepository $taskRepository;

    public function __construct($userRepository, $taskRepository) {
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepository;
    }

    public function handle($object): string {
        if ($object->conversation_message_id == 1) {
            $user = new userEntity($object->peer_id);
            $this->userRepository->save($user);
            $this->taskRepository->registerUser($user);
        }
        return $this->handleCommand($object);
    }

    protected abstract function handleCommand($object): string;
}