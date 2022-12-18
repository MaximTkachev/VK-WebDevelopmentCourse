<?php
    error_reporting(0);

    include_once "handlers/commandHandlersFactory.php";

    const CONFIRMATION_TOKEN = ""; // put your confirmation token here
    const ACCESS_TOKEN = ""; // put your access token here
    const VERSION = "5.87";

    function sendMessageToUser($peer_id, $text): void {
        $request_params = array(
            'message' => $text,
            'peer_id' => $peer_id,
            'access_token' => ACCESS_TOKEN,
            'v' => VERSION
        );
        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
    }

    function handleNewMessage($object): void {
        try {
            $mysqli = mysqli_connect("mysql", "todobot", "todobot", "todobot");

            $handler = buildHandler($object, $mysqli);
            $message = $handler->handle($object);
        } catch (Throwable $t) {
            $message = "Произошла непредвиденная ошибка на сервере";
        } finally {
            $chat_id = $object -> peer_id;
            sendMessageToUser($chat_id, $message);
        }
    }

    $data = json_decode(file_get_contents('php://input'));
    switch ($data->type) {
        case 'confirmation':
            echo CONFIRMATION_TOKEN;
            return;
        case 'message_new':
            handleNewMessage($data->object);
            break;
    }
    echo "ok";