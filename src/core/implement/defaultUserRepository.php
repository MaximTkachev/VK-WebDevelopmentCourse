<?php
require_once "core/userRepository.php";
require_once "exceptions/dbException.php";
require_once "core/abstractRepository.php";

class defaultUserRepository extends abstractRepository implements userRepository {

    private const INSERT_QUERY = "INSERT INTO users(id) VALUES(?)";

    public function __construct($mysqli) {
        parent::__construct($mysqli);
    }

    public function save(userEntity $user): void {
        $this->executeWithIntKey(self::INSERT_QUERY, $user->getId());
    }
}