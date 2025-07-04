<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'shree_yash_creations');

// Create database connection
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Initialize database tables
function initializeDatabase() {
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);
    
    // Create products table
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        category VARCHAR(100),
        image VARCHAR(255),
        stock INT DEFAULT 0,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create customers table
    $pdo->exec("CREATE TABLE IF NOT EXISTS customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        phone VARCHAR(20),
        address TEXT,
        city VARCHAR(100),
        state VARCHAR(100),
        pincode VARCHAR(10),
        country VARCHAR(100) DEFAULT 'India',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create orders table
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_number VARCHAR(20) UNIQUE NOT NULL,
        customer_id INT,
        total_amount DECIMAL(10,2) NOT NULL,
        shipping_amount DECIMAL(10,2) DEFAULT 0,
        tax_amount DECIMAL(10,2) DEFAULT 0,
        payment_method VARCHAR(50),
        payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
        order_status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
        shipping_address TEXT,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES customers(id)
    )");
    
    // Create order_items table
    $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT,
        product_id INT,
        product_name VARCHAR(255),
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (product_id) REFERENCES products(id)
    )");
    
    // Create admin table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert default admin user (password: admin123)
    $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO admin (username, password, email) VALUES ('admin', '$defaultPassword', 'admin@shreeyashcreations.com')");
    
    // Insert sample products
    $sampleProducts = [
        ['Traditional Saree Cover', 'Handcrafted cotton saree cover with traditional Indian embroidery patterns', 149.00, 'Saree Covers', 'OIP.jpeg', 25],
        ['Designer Saree Cover', 'Premium designer saree cover with traditional Indian motifs and waterproof lining', 209.00, 'Saree Covers', 'OIP.jpeg', 15],
        ['Premium Saree Cover', 'Premium saree cover with traditional zari work for special occasions', 99.00, 'Saree Covers', 'OIP.jpeg', 10],
        ['Elegant Saree Cover', 'Elegant saree cover with traditional designs and eco-friendly materials', 199.00, 'Saree Covers', 'OIP.jpeg', 20],
        ['Classic Saree Cover', 'Classic saree cover with traditional Indian designs and premium quality', 179.00, 'Saree Covers', 'OIP.jpeg', 30],
        ['Deluxe Saree Cover', 'Deluxe saree cover with premium materials and traditional designs', 159.00, 'Saree Covers', 'OIP.jpeg', 5]
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO products (name, description, price, category, image, stock) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($sampleProducts as $product) {
        $stmt->execute($product);
    }
    
    echo "Database initialized successfully!";
}

// Call this function once to set up the database
// initializeDatabase();
?> 