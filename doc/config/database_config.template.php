<?php
/**
 * Database Credentials Configuration Template
 * Copy this file to 'database_config.php' and update with your settings
 */

// ========================================
// XAMPP Default Configuration
// ========================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'myfinance');
define('DB_USER', 'root');
define('DB_PASS', ''); // XAMPP default is empty
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');

// ========================================
// Common Alternative Configurations
// ========================================

// For XAMPP with password set:
/*
define('DB_HOST', 'localhost');
define('DB_NAME', 'myfinance');
define('DB_USER', 'root');
define('DB_PASS', 'your_mysql_password');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');
*/

// For MAMP:
/*
define('DB_HOST', 'localhost');
define('DB_NAME', 'myfinance');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_PORT', 8889);
define('DB_CHARSET', 'utf8mb4');
*/

// For WAMP:
/*
define('DB_HOST', 'localhost');
define('DB_NAME', 'myfinance');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');
*/

// For Remote Database:
/*
define('DB_HOST', 'your-server.com');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');
*/

// For Custom Port (if MySQL runs on different port):
/*
define('DB_HOST', 'localhost');
define('DB_NAME', 'myfinance');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', 3307); // Custom port
define('DB_CHARSET', 'utf8mb4');
*/

// ========================================
// SSL Configuration (Advanced)
// ========================================
/*
define('DB_SSL_ENABLED', true);
define('DB_SSL_CERT', '/path/to/client-cert.pem');
define('DB_SSL_KEY', '/path/to/client-key.pem');
define('DB_SSL_CA', '/path/to/ca-cert.pem');
*/

// ========================================
// Instructions:
// ========================================
/*
1. Copy this file and rename it to 'database_config.php'
2. Uncomment the configuration that matches your setup
3. Update the values with your actual database credentials
4. Save the file
5. Test your connection by visiting /config/test.php

Common XAMPP Issues:
- If you get "Access denied", check if MySQL is running in XAMPP Control Panel
- If you get "Unknown database", create the database first in phpMyAdmin
- If you changed MySQL port, update DB_PORT accordingly
*/
?>
