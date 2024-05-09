-- File: mini_edukasi_game.sql

-- Create database
CREATE DATABASE IF NOT EXISTS mini_edukasi_game;

-- Use database
USE mini_edukasi_game;

-- Tabel User
CREATE TABLE IF NOT EXISTS User (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Tabel Autosave
CREATE TABLE IF NOT EXISTS Autosave (
    autosave_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    game_data TEXT,
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

-- Tabel Leaderboard
CREATE TABLE IF NOT EXISTS Leaderboard (
    leaderboard_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    score INT,
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);
