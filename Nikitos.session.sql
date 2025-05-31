CREATE DATABASE IF NOT EXISTS hotel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE hotel;

CREATE TABLE IF NOT EXISTS rooms (
  id INTEGER PRIMARY KEY AUTO_INCREMENT, 
  name TEXT, 
  capacity INTEGER,
  status VARCHAR(30)
);


CREATE TABLE IF NOT EXISTS reservations (
  id INTEGER PRIMARY KEY AUTO_INCREMENT, 
  name TEXT, 
  start DATETIME, 
  end DATETIME,
  room_id INTEGER,
  status VARCHAR(30),
  paid INTEGER,
  FOREIGN KEY (room_id) REFERENCES rooms(id)
);

INSERT INTO rooms (name, capacity, status) VALUES
('Кімната 1', 1, 'готова'),
('Кімната 2', 2, 'прибирається'),
('Кімната 3', 3, 'брудна'),
('Кімната 4', 2, 'готова'),
('Кімната 5', 4, 'готова'),
('Кімната 6', 2, 'прибирається'),
('Кімната 7', 1, 'готова'),
('Кімната 8', 3, 'брудна'),
('Кімната 9', 2, 'готова'),
('Кімната 10', 4, 'готова');
