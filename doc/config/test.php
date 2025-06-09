<?php
/**
 * Database Connection Test
 * This file tests the new configuration structure
 */

// Load the new configuration
require_once '../config/app.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test - <?php echo APP_NAME; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .test-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        .test-result {
            margin: 15px 0;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
        }
        .success {
            background: rgba(40, 167, 69, 0.3);
            border: 2px solid #28a745;
        }
        .error {
            background: rgba(220, 53, 69, 0.3);
            border: 2px solid #dc3545;
        }
        .info {
            background: rgba(23, 162, 184, 0.3);
            border: 2px solid #17a2b8;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>🧪 Database Connection Test</h1>
        <p>Testing the new configuration structure for <?php echo APP_NAME; ?> v<?php echo APP_VERSION; ?></p>
        
        <?php
        echo '<div class="test-result info">🔧 Environment: ' . (defined('ENVIRONMENT') ? ENVIRONMENT : 'development') . '</div>';
        echo '<div class="test-result info">📊 App Name: ' . APP_NAME . '</div>';
        echo '<div class="test-result info">🏠 Database Host: ' . DB_HOST . '</div>';
        echo '<div class="test-result info">🔌 Database Port: ' . (defined('DB_PORT') ? DB_PORT : '3306') . '</div>';
        echo '<div class="test-result info">🗄️ Database Name: ' . DB_NAME . '</div>';
        echo '<div class="test-result info">👤 Database User: ' . DB_USER . '</div>';
        echo '<div class="test-result info">🔑 Database Password: ' . (empty(DB_PASS) ? '(none)' : '••••••••') . '</div>';
        
        // Test PDO Connection
        try {
            $pdo = DatabaseConnection::getPDO();
            echo '<div class="test-result success">✅ PDO Connection: Successfully connected!</div>';
            
            // Test if database exists
            $stmt = $pdo->query("SELECT DATABASE() as current_db");
            $result = $stmt->fetch();
            echo '<div class="test-result success">🗄️ Current Database: ' . $result['current_db'] . '</div>';
            
            // Test if tables exist
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            if (!empty($tables)) {
                echo '<div class="test-result success">📋 Tables Found: ' . implode(', ', $tables) . '</div>';
            } else {
                echo '<div class="test-result error">⚠️ No tables found. Please run database setup.</div>';
            }
            
        } catch (Exception $e) {
            echo '<div class="test-result error">❌ PDO Connection Failed: ' . $e->getMessage() . '</div>';
        }
        
        // Test MySQLi Connection
        try {
            $mysqli = DatabaseConnection::getMySQLi();
            echo '<div class="test-result success">✅ MySQLi Connection: Successfully connected!</div>';
            echo '<div class="test-result info">🔗 MySQLi Version: ' . $mysqli->server_info . '</div>';
        } catch (Exception $e) {
            echo '<div class="test-result error">❌ MySQLi Connection Failed: ' . $e->getMessage() . '</div>';
        }
        
        // Test Security Helper
        echo '<div class="test-result info">🔒 Security Helper Test:</div>';
        $testPassword = 'test123';
        $hashedPassword = SecurityHelper::hashPassword($testPassword);
        $passwordVerified = SecurityHelper::verifyPassword($testPassword, $hashedPassword);
        echo '<div class="test-result ' . ($passwordVerified ? 'success' : 'error') . '">
                🔐 Password Hashing: ' . ($passwordVerified ? 'Working' : 'Failed') . '
              </div>';
        
        // Test Session
        echo '<div class="test-result info">🎫 Session Status: ' . 
             (session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive') . '</div>';
        
        // Test App Helper
        echo '<div class="test-result info">🚀 App Helper Test:</div>';
        try {
            $db = App::db();
            echo '<div class="test-result success">✅ App::db() method: Working</div>';
        } catch (Exception $e) {
            echo '<div class="test-result error">❌ App::db() method: Failed</div>';
        }
        
        // Test file permissions
        echo '<div class="test-result info">📁 Directory Status:</div>';
        echo '<div class="test-result ' . (is_writable(LOG_DIR) ? 'success' : 'error') . '">
                📝 Logs Directory: ' . (is_writable(LOG_DIR) ? 'Writable' : 'Not writable') . ' (' . LOG_DIR . ')
              </div>';
        echo '<div class="test-result ' . (is_writable(UPLOAD_DIR) ? 'success' : 'error') . '">
                📤 Uploads Directory: ' . (is_writable(UPLOAD_DIR) ? 'Writable' : 'Not writable') . ' (' . UPLOAD_DIR . ')
              </div>';
        ?>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="setup.php" style="color: white; text-decoration: none; background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 5px; margin-right: 10px;">
                ⚙️ Database Setup
            </a>
            <a href="../index.php" style="color: white; text-decoration: none; background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 5px;">
                🏠 Back to Home
            </a>
        </div>
    </div>
</body>
</html>
