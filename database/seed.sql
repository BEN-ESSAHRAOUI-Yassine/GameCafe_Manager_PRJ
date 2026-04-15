-- Insert data for users tables

INSERT INTO users (name, email, phone, password, role) VALUES
('admin', 'admin@mail.com', '0600000001','$2y$10$Nk2jaWseOPC9G6er/oh6MudzvMMdtLDlV.pkW/jIHZJAKXcSEQT.e', 'admin'),/*adminpass*/
('ali', 'ali@mail.com', '0600000002','$2y$10$yUoCxmuUpv5w7uTA/RRgDOuBaOPQow1J8kNDMXF1MLE90aXIuapxa', 'client'),/*chefpass*/
('sara', 'sara@mail.com', '0600000003','$2y$10$yUoCxmuUpv5w7uTA/RRgDOuBaOPQow1J8kNDMXF1MLE90aXIuapxa', 'client'),
('ahmed', 'ahmed@mail.com', '0600000004','$2y$10$yUoCxmuUpv5w7uTA/RRgDOuBaOPQow1J8kNDMXF1MLE90aXIuapxa', 'client');


-- Insert data from 
INSERT INTO tables (name, capacity, status) VALUES
('Table 1', 2, 'available'),
('Table 2', 4, 'available'),
('Table 3', 6, 'occupied'),
('Table 4', 4, 'available'),
('Table 5', 8, 'occupied'),
('Table 6', 2, 'available'),
('Table 7', 6, 'available'),
('Table 8', 4, 'occupied'),
('Table 9', 10, 'available'),
('VIP Table', 12, 'occupied');


-- insert data from games
INSERT INTO games (name, category, description, difficulty, min_players, max_players, duration_minutes, status) VALUES
('Catan', 'Stratégie', 'Trade and build.', 3, 3, 4, 90, 'available'),
('Uno', 'Ambiance', 'Card fun.', 1, 2, 10, 30, 'available'),
('Monopoly', 'Famille', 'Real estate.', 2, 2, 6, 120, 'available'),
('Chess', 'Experts', 'Classic duel.', 5, 2, 2, 60, 'available'),
('Dixit', 'Ambiance', 'Storytelling.', 2, 3, 6, 45, 'available'),
('7 Wonders', 'Stratégie', 'Civilization.', 4, 3, 7, 60, 'in_use'),
('Carcassonne', 'Stratégie', 'Tile placing.', 2, 2, 5, 45, 'available'),
('Risk', 'Experts', 'World conquest.', 4, 2, 6, 180, 'available'),
('Jenga', 'Ambiance', 'Stack blocks.', 1, 2, 8, 20, 'available'),
('Scrabble', 'Famille', 'Word game.', 3, 2, 4, 60, 'available');

-- insert data rom reservation 
INSERT INTO reservations (user_id, table_id, party_size, reserved_at, duration_hours, status) VALUES
(2,1,2,'2026-04-16 18:00:00',2,'confirmed'),
(3,2,4,'2026-04-16 19:00:00',2,'pending'),
(4,3,5,'2026-04-16 20:00:00',3,'completed'),
(2,4,3,'2026-04-17 17:00:00',2,'cancelled'),
(3,5,6,'2026-04-17 18:00:00',3,'confirmed'),
(4,6,2,'2026-04-17 19:00:00',1,'pending'),
(2,7,4,'2026-04-18 18:00:00',2,'confirmed'),
(3,8,3,'2026-04-18 20:00:00',2,'completed'),
(4,9,8,'2026-04-19 21:00:00',3,'pending'),
(2,10,6,'2026-04-19 22:00:00',4,'confirmed');

-- insert data from sessions
INSERT INTO sessions (reservation_id, game_id, table_id, started_at, ended_at) VALUES
(1,1,1,'2026-04-16 18:00:00','2026-04-16 20:00:00'),
(2,2,2,'2026-04-16 19:00:00',NULL),
(3,3,3,'2026-04-16 20:00:00','2026-04-16 23:00:00'),
(4,4,4,'2026-04-17 17:00:00',NULL),
(5,5,5,'2026-04-17 18:00:00','2026-04-17 21:00:00'),
(6,6,6,'2026-04-17 19:00:00',NULL),
(7,7,7,'2026-04-18 18:00:00','2026-04-18 20:00:00'),
(8,8,8,'2026-04-18 20:00:00','2026-04-18 22:00:00'),
(9,9,9,'2026-04-19 21:00:00',NULL),
(10,10,10,'2026-04-19 22:00:00',NULL);

INSERT INTO game_copies (game_id, copy_number, status) VALUES
(1,1,'available'),
(1,2,'in_use'),
(2,1,'available'),
(2,2,'available'),
(3,1,'available'),
(4,1,'in_use'),
(5,1,'available'),
(6,1,'available'),
(7,1,'in_use'),
(8,1,'available');