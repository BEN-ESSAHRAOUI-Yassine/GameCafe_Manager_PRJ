-- Database name
CREATE DATABASE IF NOT EXISTS Aji_L3bo_Cafe;
USE Aji_L3bo_Cafe;


-- Tabels

-- 1. users
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  phone VARCHAR(20),
  password VARCHAR(255) NOT NULL,
  role ENUM('client', 'admin') NOT NULL DEFAULT 'client',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- 2. tables
CREATE TABLE tables (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  capacity TINYINT NOT NULL,
  status ENUM('available', 'occupied') NOT NULL DEFAULT 'available'
);


-- 3. games
CREATE TABLE games (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  category ENUM('Stratégie', 'Ambiance', 'Famille', 'Experts') NOT NULL,
  description TEXT,
  difficulty TINYINT NOT NULL CHECK (difficulty BETWEEN 1 AND 5),
  min_players TINYINT NOT NULL,
  max_players TINYINT NOT NULL,
  duration_minutes INT NOT NULL,
  status ENUM('available', 'in_use') NOT NULL DEFAULT 'available',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- 4. reservations
CREATE TABLE reservations (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  table_id INT NOT NULL,
  party_size TINYINT NOT NULL,
  reserved_at DATETIME NOT NULL,
  duration_hours TINYINT NOT NULL,
  status ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (table_id) REFERENCES tables(id)
);


-- 5. sessions
CREATE TABLE sessions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  reservation_id INT NOT NULL,
  game_id INT NOT NULL,
  table_id INT NOT NULL,
  started_at DATETIME NOT NULL,
  ended_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (reservation_id) REFERENCES reservations(id),
  FOREIGN KEY (game_id) REFERENCES games(id),
  FOREIGN KEY (table_id) REFERENCES tables(id)
);

-- 6. game_copies
CREATE TABLE game_copies (
    id INT AUTO_INCREMENT PRIMARY KEY,

    game_id INT NOT NULL,

    copy_number INT NOT NULL,

    status ENUM('available', 'in_use') DEFAULT 'available',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (game_id)
    REFERENCES games(id)
    ON DELETE CASCADE
);



