<?php

abstract class abstractRepository {

    protected mysqli $mysqli;

    protected function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * @param string $query
     * @param int $key
     * @return mysqli_stmt
     * @throws dbException
     */
    protected function executeWithIntKey(string $query, int $key): mysqli_stmt {
        $stmt = $this->mysqli->prepare($query);
        if (!$stmt) {
            throw new dbException("bad SQL-statement", 500);
        }
        $stmt->bind_param("i", $key);
        $res = $stmt->execute();
        if (!$res) {
            throw new dbException("error while executing SQL-statement", 500);
        }
        return $stmt;
    }

    /**
     * @param string $query
     * @param int $key1
     * @param int $key2
     * @return mysqli_stmt
     * @throws dbException
     */
    protected function executeWithTwoIntKeys(string $query, int $key1, int $key2): mysqli_stmt {
        $stmt = $this->mysqli->prepare($query);
        if (!$stmt) {
            throw new dbException("bad SQL-statement", 500);
        }
        $stmt->bind_param("ii", $key1, $key2);
        $res = $stmt->execute();
        if (!$res) {
            throw new dbException("error while executing SQL-statement", 500);
        }
        return $stmt;
    }

    /**
     * @param string $query
     * @param int $key
     * @return int
     * @throws dbException
     */
    protected function executeWithIntResult(string $query, int $key): int {
        $stmt = $this->executeWithIntKey($query, $key);
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }
}