CREATE DATABASE IF NOT EXISTS todobot;
USE todobot;
CREATE TABLE IF NOT EXISTS users (
    id BIGINT PRIMARY KEY
);
CREATE TABLE IF NOT EXISTS tasks (
    owner_id BIGINT references users(id),
    local_id BIGINT,
    description TEXT,
    current_status ENUM('new', 'done') DEFAULT 'new',
    estimated_completion_date DATE,

    primary key (owner_id, local_id)
);
CREATE TABLE IF NOT EXISTS task_next_ids (
    user_id BIGINT PRIMARY KEY REFERENCES users(id),
    next_id BIGINT DEFAULT 0
);