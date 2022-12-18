<?php
require_once "models/createTaskDto.php";

interface taskRepository {

    /**
     * @param int $ownerId
     * @param int $id
     * @return taskEntity|null
     * @throws dbException
     * @throws notFoundException
     */
    public function getById(int $ownerId, int $id): ?taskEntity;

    /**
     * @param userEntity $userEntity
     * @return void
     * @throws dbException
     */
    public function registerUser(userEntity $userEntity): void;

    /**
     * @param createTaskDto $dto
     * @return int
     * @throws dbException
     */
    public function save(createTaskDto $dto): int;

    /**
     * @param int $ownerId
     * @param int $id
     * @return void
     * @throws dbException
     * @throws notFoundException
     */
    public function markAsDone(int $ownerId, int $id): void;

    /**
     * @param int $ownerId
     * @param int $id
     * @return void
     * @throws dbException
     * @throws notFoundException
     */
    public function remove(int $ownerId, int $id): void;

    /**
     * @param int $ownerId
     * @return array
     * @throws dbException
     */
    public function getUndoneByOwnerId(int $ownerId): array;

    /**
     * @param int $ownerId
     * @return array
     * @throws dbException
     */
    public function getAllByOwnerId(int $ownerId): array;
}