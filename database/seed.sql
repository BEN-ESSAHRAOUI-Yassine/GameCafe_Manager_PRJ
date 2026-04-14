-- Insert data fromusers tables

INSERT INTO users (name, email, phone, password, role)
VALUES 
('Ahmed Ben', 'ahmed@email.com', '0600000001', 'hashed_password', 'client'),
('Sara Ali', 'sara@email.com', '0600000002', 'hashed_password', 'client');


-- Insert data from 
INSERT INTO tables (name, capacity, status)
VALUES 
('Table 1', 4, 'available'),
('Table 2', 6, 'available');


-- insert data from games
INSERT INTO games (name, category, description, difficulty, min_players, max_players, duration_minutes, status)
VALUES 
('Chess', 'strategy', 'Classic chess game', 3, 2, 2, 30, 'active'),
('Monopoly', 'board', 'Family board game', 2, 2, 6, 120, 'active');

-- insert data rom reservation 
INSERT INTO reservations (user_id, table_id, party_size, reserved_at, duration_hours, status)
VALUES 
(1, 1, 4, '2026-04-15 18:00:00', 2, 'confirmed'),
(2, 2, 3, '2026-04-16 20:00:00', 1, 'confirmed');

-- insert data from sessions
INSERT INTO sessions (reservation_id, game_id, table_id, started_at, ended_at)
VALUES 
(1, 2, 1, '2026-04-15 18:00:00', '2026-04-15 19:00:00'),
(1, 1, 1, '2026-04-15 19:00:00', '2026-04-15 20:00:00');