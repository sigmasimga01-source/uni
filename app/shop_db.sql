
CREATE DATABASE IF NOT EXISTS shop_db;
USE shop_db;

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    name VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    balance DECIMAL(10, 2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

INSERT INTO items (name, description, price, stock, image) VALUES
('Laptop', 'laptop with 16GB RAM', 999.99, 10, 'https://pngimg.com/uploads/laptop/laptop_PNG101811.png'),
('Smartphone', 'latest smartphone', 699.99, 25, 'https://pngimg.com/uploads/smartphone/smartphone_PNG8501.png'),
('Headphones', 'Wireless headphones', 199.99, 50, 'https://pngimg.com/uploads/headphones/headphones_PNG7627.png'),
('Keyboard', 'gaming keyboard RGB', 89.99, 30, 'https://pngimg.com/uploads/keyboard/keyboard_PNG101839.png'),
('Mouse', 'wireless mouse', 49.99, 40, 'https://pngimg.com/uploads/computer_mouse/computer_mouse_PNG7664.png'),
('Monitor', '27 inch 4K monitor', 449.99, 15, 'https://pngimg.com/uploads/monitor/laptop_PNG5872.png'),
('USB Cable', 'USB-C cable', 9.99, 100, 'https://pngimg.com/uploads/usb_cable/usb_cable_PNG5.png'),
('Webcam', 'HD webcam', 79.99, 20, 'https://pngimg.com/uploads/web_camera/web_camera_PNG101403.png');