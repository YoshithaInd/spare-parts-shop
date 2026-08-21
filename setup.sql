-- ===== MEMBER 1: Database Setup =====
-- Run in phpMyAdmin > SQL tab > Go

CREATE DATABASE IF NOT EXISTS vehicle_parts_store;
USE vehicle_parts_store;

-- Admin table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Default admin login: username = admin, password = admin123
INSERT INTO admins (username, password) VALUES
('admin', '$2y$10$400aJN2L3nblh5X9ijSMwO6n5FugCkpGllJi9k8eIaUE6e5kVcnUe');
-- NOTE: This hash corresponds to password "admin123"

-- Spare parts table
CREATE TABLE IF NOT EXISTS parts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    part_name VARCHAR(150) NOT NULL,
    vehicle_make VARCHAR(60) NOT NULL,
    vehicle_model VARCHAR(60) NOT NULL,
    category VARCHAR(60) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255) DEFAULT 'https://via.placeholder.com/200x150?text=Part',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO parts (part_name, vehicle_make, vehicle_model, category, price, stock, image_url) VALUES
('Brake Pad Set', 'Toyota', 'Corolla', 'Brakes', 45.00, 20, 'https://via.placeholder.com/200x150?text=Brake+Pad'),
('Air Filter', 'Honda', 'Civic', 'Engine', 15.50, 35, 'https://via.placeholder.com/200x150?text=Air+Filter'),
('Shock Absorber', 'Nissan', 'Sunny', 'Suspension', 60.00, 12, 'https://via.placeholder.com/200x150?text=Shock+Absorber'),
('Spark Plug', 'Toyota', 'Prius', 'Engine', 8.00, 50, 'https://via.placeholder.com/200x150?text=Spark+Plug'),
('Brake Disc', 'Honda', 'Accord', 'Brakes', 70.00, 10, 'https://via.placeholder.com/200x150?text=Brake+Disc');

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_address VARCHAR(255) NOT NULL,
    part_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    payment_status ENUM('Paid','Pending','Failed') NOT NULL DEFAULT 'Paid',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (part_id) REFERENCES parts(id)
);
