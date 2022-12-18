<?php

enum taskStatus {
    case NEW;
    case DONE;
    case UNKNOWN;

    public static function fromString($value): taskStatus {
        if ($value == "new") {
            return taskStatus::NEW;
        }
        if ($value == "done") {
            return taskStatus::DONE;
        }
        return taskStatus::UNKNOWN;
    }

    public function toString(): string {
        return match ($this) {
            taskStatus::NEW => "new",
            taskStatus::DONE => "done",
            default => "unknown"
        };
    }
}
