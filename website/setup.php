<?php
require_once 'config.php';

// Initialize the database
initializeDatabase();

echo "<h2>Database Setup Complete!</h2>";
echo "<p>Your Shree Yash Creations e-commerce system is now ready.</p>";
echo "<h3>Default Admin Login:</h3>";
echo "<p><strong>Username:</strong> admin</p>";
echo "<p><strong>Password:</strong> admin123</p>";
echo "<p><a href='admin_panel.html'>Go to Admin Panel</a></p>";
echo "<p><a href='home.html'>Go to Website</a></p>";
?> 