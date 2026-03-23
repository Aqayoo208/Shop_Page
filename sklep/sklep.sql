CREATE DATABASE IF NOT EXISTS sklep;
USE sklep;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE songs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    year INT,
    duration VARCHAR(10)
);

INSERT INTO products (name, price, image) VALUES
('Mąka pszenna', 3.99, 'https://via.placeholder.com/150?text=Maka'),
('Cukier', 2.49, 'https://via.placeholder.com/150?text=Cukier'),
('Jajka', 8.99, 'https://via.placeholder.com/150?text=Jajka'),
('Masło', 5.99, 'https://via.placeholder.com/150?text=Maslo'),
('Mleko', 3.49, 'https://via.placeholder.com/150?text=Mleko');

INSERT INTO songs (title, artist, year, duration) VALUES
('Bohemian Rhapsody', 'Queen', 1975, '5:55'),
('Stairway to Heaven', 'Led Zeppelin', 1971, '8:02'),
('Imagine', 'John Lennon', 1971, '3:01'),
('Hotel California', 'Eagles', 1977, '6:30');