CREATE DATABASE shop;
USE shop;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  price DECIMAL(10,2),
  stock INT
);

CREATE TABLE sales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(255),
  total DECIMAL(10,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sale_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sale_id INT,
  product_id INT,
  quantity INT,
  price DECIMAL(10,2)
);

CREATE TABLE purchases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_name VARCHAR(255),
  total DECIMAL(10,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE purchase_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  purchase_id INT,
  product_id INT,
  quantity INT,
  price DECIMAL(10,2)
);