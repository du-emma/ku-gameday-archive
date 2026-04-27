CREATE DATABASE IF NOT EXISTS ku_gameday_archive;
USE ku_gameday_archive;

DROP TABLE IF EXISTS Reviews;
DROP TABLE IF EXISTS PlayerStats;
DROP TABLE IF EXISTS Players;
DROP TABLE IF EXISTS Games;
DROP TABLE IF EXISTS Users;

CREATE TABLE Users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE Games (
    gameID INT AUTO_INCREMENT PRIMARY KEY,
    gameDate DATE NOT NULL,
    season VARCHAR(20),
    opponent VARCHAR(100) NOT NULL,
    location VARCHAR(20),
    KUscore INT,
    opponentScore INT,
    result VARCHAR(10)
);

CREATE TABLE Players (
    playerID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    number INT,
    year INT,
    position VARCHAR(20),
    classYear VARCHAR(30)
);

CREATE TABLE PlayerStats (
    statID INT AUTO_INCREMENT PRIMARY KEY,
    gameID INT NOT NULL,
    playerID INT NOT NULL,
    points INT,
    rebounds INT,
    assists INT,
    steals INT,
    blocks INT,
    minutesPlayed INT,
    FOREIGN KEY (gameID) REFERENCES Games(gameID),
    FOREIGN KEY (playerID) REFERENCES Players(playerID)
);

CREATE TABLE Reviews (
    reviewID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    gameID INT NOT NULL,
    rating FLOAT CHECK (rating >= 1 AND rating <= 10),
    section VARCHAR(50),
    comment TEXT,
    reviewDate DATE,
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (gameID) REFERENCES Games(gameID)
);

INSERT INTO Users (name, email, password) VALUES
('Demo User', 'demo@ku.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.');

INSERT INTO Games (gameDate, season, opponent, location, KUscore, opponentScore, result) VALUES
('2024-01-13', '2023-2024', 'Oklahoma', 'Home', 78, 66, 'Win'),
('2024-01-20', '2023-2024', 'West Virginia', 'Away', 85, 91, 'Loss'),
('2024-02-05', '2023-2024', 'Kansas State', 'Away', 70, 75, 'Loss'),
('2024-02-24', '2023-2024', 'Texas', 'Home', 86, 67, 'Win'),
('2024-03-05', '2023-2024', 'Kansas State', 'Home', 90, 68, 'Win');

INSERT INTO Players (name, number, year, position, classYear) VALUES
('Hunter Dickinson', 1, 2024, 'Center', 'Senior'),
('Kevin McCullar Jr.', 15, 2024, 'Guard', 'Senior'),
('KJ Adams Jr.', 24, 2024, 'Forward', 'Junior'),
('Dajuan Harris Jr.', 3, 2024, 'Guard', 'Senior'),
('Johnny Furphy', 10, 2024, 'Guard', 'Freshman'),
('Elmarko Jackson', 13, 2024, 'Guard', 'Freshman'),
('Parker Braun', 23, 2024, 'Forward', 'Senior'),
('Nicolas Timberlake', 25, 2024, 'Guard', 'Senior'),
('Jamari McDowell', 11, 2024, 'Guard', 'Freshman');


INSERT INTO PlayerStats (gameID, playerID, points, rebounds, assists, steals, blocks, minutesPlayed) VALUES
(1, 1, 24, 14, 2, 0, 5, 33),   
(1, 2, 21, 4, 4, 1, 0, 39),  
(1, 3, 15, 10, 3, 1, 1, 40),   
(1, 4, 7, 1, 8, 3, 0, 40),    
(1, 5, 7, 3, 0, 2, 0, 19),    
(1, 6, 2, 2, 0, 0, 1, 18),     
(1, 7, 2, 1, 0, 0, 0, 7),    
(1, 8, 0, 0, 0, 0, 0, 3),    
(1, 9, 0, 0, 0, 0, 0, 1),     


(2, 1, 19, 12, 1, 0, 1, 33),
(2, 2, 11, 2, 7, 1, 0, 34),
(2, 3, 14, 7, 2, 1, 1, 31),
(2, 4, 20, 6, 3, 1, 0, 35),

(3, 1, 21, 10, 2, 1, 2, 34),
(3, 2, 8, 3, 9, 2, 0, 36),
(3, 3, 16, 5, 4, 1, 1, 33),
(3, 4, 17, 4, 5, 2, 0, 35),

(4, 1, 22, 13, 1, 0, 3, 32),
(4, 2, 10, 2, 10, 3, 0, 36),
(4, 3, 18, 8, 2, 1, 1, 33),
(4, 4, 21, 7, 4, 2, 0, 37),

(5, 1, 25, 15, 2, 1, 2, 35),
(5, 2, 12, 4, 11, 2, 0, 36),
(5, 3, 20, 7, 3, 1, 1, 34),
(5, 4, 23, 6, 5, 3, 0, 38);

INSERT INTO Reviews (userID, gameID, rating, section, comment, reviewDate) VALUES
(1, 1, 9, 'Student Section', 'Great energy and fun atmosphere.', '2024-01-14'),
(1, 2, 6, 'Upper Level', 'Tough loss but still a good game experience.', '2024-01-21');