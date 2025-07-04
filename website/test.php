<?php
// Simple test file to verify server setup
echo "<h1>Shree Yash Creations - Server Test</h1>";

// Test 1: PHP Version
echo "<h2>1. PHP Version Check</h2>";
echo "PHP Version: " . phpversion() . "<br>";
if (version_compare(PHP_VERSION, '7.4.0') >= 0) {
    echo "✅ PHP version is compatible<br>";
} else {
    echo "❌ PHP version is too old. Need 7.4+<br>";
}

// Test 2: Required Extensions
echo "<h2>2. Required Extensions</h2>";
$required_extensions = ['pdo', 'pdo_mysql', 'json', 'curl'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext extension is loaded<br>";
    } else {
        echo "❌ $ext extension is missing<br>";
    }
}

// Test 3: Database Connection
echo "<h2>3. Database Connection Test</h2>";
try {
    require_once 'config.php';
    $pdo = getDBConnection();
    echo "✅ Database connection successful<br>";
    
    // Test if tables exist
    $tables = ['products', 'customers', 'orders', 'admin'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Table '$table' exists<br>";
        } else {
            echo "❌ Table '$table' missing<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    echo "<strong>Solution:</strong> Check your database credentials in config.php<br>";
}

// Test 4: File Permissions
echo "<h2>4. File Permissions Test</h2>";
$files_to_check = [
    'config.php' => 'Configuration file',
    'api/contact.php' => 'Contact API',
    'api/products.php' => 'Products API',
    'api/orders.php' => 'Orders API',
    'OIP.jpeg' => 'Product image'
];

foreach ($files_to_check as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $description ($file) exists<br>";
        if (is_readable($file)) {
            echo "✅ $description is readable<br>";
        } else {
            echo "❌ $description is not readable<br>";
        }
    } else {
        echo "❌ $description ($file) missing<br>";
    }
}

// Test 5: Email Function
echo "<h2>5. Email Function Test</h2>";
if (function_exists('mail')) {
    echo "✅ mail() function is available<br>";
} else {
    echo "❌ mail() function is not available<br>";
    echo "<strong>Solution:</strong> Contact your hosting provider to enable mail() function<br>";
}

// Test 6: Directory Structure
echo "<h2>6. Directory Structure Test</h2>";
$directories = ['api'];
foreach ($directories as $dir) {
    if (is_dir($dir)) {
        echo "✅ Directory '$dir' exists<br>";
    } else {
        echo "❌ Directory '$dir' missing<br>";
    }
}

echo "<h2>7. Next Steps</h2>";
echo "<p>If all tests pass, your server is ready! Here's what to do next:</p>";
echo "<ol>";
echo "<li>Visit <a href='setup.php'>setup.php</a> to initialize the database</li>";
echo "<li>Visit <a href='home.html'>home.html</a> to see your website</li>";
echo "<li>Visit <a href='admin_panel.html'>admin_panel.html</a> to access admin panel</li>";
echo "<li>Login with: admin / admin123</li>";
echo "</ol>";

echo "<h2>8. Common Issues & Solutions</h2>";
echo "<ul>";
echo "<li><strong>Database Error:</strong> Update config.php with your hosting database credentials</li>";
echo "<li><strong>404 Errors:</strong> Check file permissions (755 for folders, 644 for files)</li>";
echo "<li><strong>Contact Form Not Working:</strong> Contact hosting provider to enable mail() function</li>";
echo "<li><strong>Images Not Loading:</strong> Ensure OIP.jpeg is uploaded and has correct permissions</li>";
echo "</ul>";

echo "<p><strong>Need Help?</strong> Check the SETUP_GUIDE.md file for detailed instructions.</p>";
?> 