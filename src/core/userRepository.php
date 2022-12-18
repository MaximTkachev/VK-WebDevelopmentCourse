<?php
require_once "models/userEntity.php";

interface userRepository {

    /**
     * @throws dbException
     */
    public function save(userEntity $user): void;
}