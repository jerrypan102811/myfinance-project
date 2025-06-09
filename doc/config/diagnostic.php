<?php
/**
 * Database Diagnostic Tool
 * Helps troubleshoot database connection issues
 */

// Load configuration
require_once '../config/app.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Diagnostics - <?php echo APP_NAME; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .diagnostic-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        .test-section {
            margin: 20px 0;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .success { background: rgba(40, 167, 69, 0.3); border: 2px solid #28a745; }
        .error { background: rgba(220, 53, 69, 0.3); border: 2px solid #dc3545; }
        .warning { background: rgba(255, 193, 7, 0.3); border: 2px solid #ffc107; color: #212529; }
        .info { background: rgba(23, 162, 184, 0.3); border: 2px solid #17a2b8; }
        .btn {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn:hover { background: #218838; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        code { background: rgba(0,0,0,0.3); padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="diagnostic-container">
        <h1>🔍 Database Diagnostics</h1>
        <p>Comprehensive database troubleshooting for <?php echo APP_NAME; ?></p>

        <!-- Configuration Check -->
        <div class="test-section">
            <h2>📋 Configuration Status</h2>
            <?php
            echo '<div class="status info">Database Host: ' . DB_HOST . '</div>';
            echo '<div class="status info">Database Port: ' . (defined('DB_PORT') ? DB_PORT : '3306') . '</div>';
            echo '<div class="status info">Database Name: ' . DB_NAME . '</div>';
            echo '<div class="status info">Database User: ' . DB_USER . '</div>';
            echo '<div class="status info">Password Set: ' . (empty(DB_PASS) ? 'No' : 'Yes') . '</div>';
            ?>
        </div>

        <!-- MySQL Service Check -->
        <div class="test-section">
            <h2>🔧 MySQL Service Status</h2>
            <?php
            $mysqlRunning = false;
            $output = shell_exec('ps aux | grep -i mysql | grep -v grep');
            if (!empty($output)) {
                echo '<div class="status success">✅ MySQL Service: Running</div>';
                $mysqlRunning = true;
                
                // Check XAMPP MySQL specifically
                if (strpos($output, 'XAMPP') !== false) {
                    echo '<div class="status success">✅ XAMPP MySQL: Detected</div>';
                }
            } else {
                echo '<div class="status error">❌ MySQL Service: Not Running</div>';
                echo '<div class="status warning">⚠️ Please start MySQL in XAMPP Control Panel</div>';
            }
            ?>
        </div>

        <!-- Connection Test -->
        <div class="test-section">
            <h2>🔗 Database Connection Test</h2>
            <?php
            if ($mysqlRunning) {
                try {
                    // Test basic connection without database
                    $testPdo = new PDO("mysql:host=" . DB_HOST . ";port=" . (defined('DB_PORT') ? DB_PORT : 3306), DB_USER, DB_PASS);
                    echo '<div class="status success">✅ MySQL Server Connection: Success</div>';
                    
                    // Test specific database
                    try {
                        $pdo = DatabaseConnection::getPDO();
                        echo '<div class="status success">✅ Database Connection: Success</div>';
                        
                        // Test database exists
                        $stmt = $pdo->query("SELECT DATABASE() as current_db");
                        $result = $stmt->fetch();
                        echo '<div class="status success">✅ Current Database: ' . $result['current_db'] . '</div>';
                        
                    } catch (Exception $e) {
                        echo '<div class="status error">❌ Database Connection Failed: ' . $e->getMessage() . '</div>';
                        
                        // Check if database exists
                        try {
                            $stmt = $testPdo->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
                            if ($stmt->rowCount() == 0) {
                                echo '<div class="status warning">⚠️ Database "' . DB_NAME . '" does not exist</div>';
                                echo '<div class="status info">💡 <a href="?action=create_db" class="btn">Create Database</a></div>';
                            }
                        } catch (Exception $e2) {
                            echo '<div class="status error">❌ Cannot check databases: ' . $e2->getMessage() . '</div>';
                        }
                    }
                    
                } catch (Exception $e) {
                    echo '<div class="status error">❌ MySQL Server Connection Failed: ' . $e->getMessage() . '</div>';
                    
                    // Common error solutions
                    if (strpos($e->getMessage(), 'Access denied') !== false) {
                        echo '<div class="status warning">💡 Solution: Check username/password in database_config.php</div>';
                    } elseif (strpos($e->getMessage(), 'Connection refused') !== false) {
                        echo '<div class="status warning">💡 Solution: Start MySQL in XAMPP Control Panel</div>';
                    } elseif (strpos($e->getMessage(), 'No such file') !== false) {
                        echo '<div class="status warning">💡 Solution: Check if MySQL socket file exists</div>';
                    }
                }
            }
            ?>
        </div>

        <!-- Table Check -->
        <div class="test-section">
            <h2>📊 Database Tables</h2>
            <?php
            try {
                $pdo = DatabaseConnection::getPDO();
                $stmt = $pdo->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                if (!empty($tables)) {
                    echo '<div class="status success">✅ Tables Found: ' . count($tables) . '</div>';
                    foreach ($tables as $table) {
                        $stmt = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
                        $count = $stmt->fetch()['count'];
                        echo '<div class="status info">📋 ' . $table . ': ' . $count . ' records</div>';
                    }
                } else {
                    echo '<div class="status warning">⚠️ No tables found in database</div>';
                    echo '<div class="status info">💡 <a href="?action=init_db" class="btn">Initialize Database</a></div>';
                }
                
            } catch (Exception $e) {
                echo '<div class="status error">❌ Cannot check tables: ' . $e->getMessage() . '</div>';
            }
            ?>
        </div>

        <!-- Actions -->
        <?php
        if (isset($_GET['action'])) {
            echo '<div class="test-section">';
            echo '<h2>🛠️ Action Results</h2>';
            
            switch ($_GET['action']) {
                case 'create_db':
                    try {
                        $testPdo = new PDO("mysql:host=" . DB_HOST . ";port=" . (defined('DB_PORT') ? DB_PORT : 3306), DB_USER, DB_PASS);
                        $testPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                        echo '<div class="status success">✅ Database "' . DB_NAME . '" created successfully!</div>';
                        echo '<div class="status info">🔄 <a href="diagnostic.php" class="btn">Refresh Page</a></div>';
                    } catch (Exception $e) {
                        echo '<div class="status error">❌ Failed to create database: ' . $e->getMessage() . '</div>';
                    }
                    break;
                    
                case 'init_db':
                    try {
                        $sqlFile = '../database/init.sql';
                        if (file_exists($sqlFile)) {
                            $sql = file_get_contents($sqlFile);
                            $pdo = DatabaseConnection::getPDO();
                            $pdo->exec($sql);
                            echo '<div class="status success">✅ Database initialized successfully!</div>';
                            echo '<div class="status info">🔄 <a href="diagnostic.php" class="btn">Refresh Page</a></div>';
                        } else {
                            echo '<div class="status error">❌ SQL initialization file not found</div>';
                        }
                    } catch (Exception $e) {
                        echo '<div class="status error">❌ Failed to initialize database: ' . $e->getMessage() . '</div>';
                    }
                    break;
            }
            echo '</div>';
        }
        ?>

        <!-- Quick Solutions -->
        <div class="test-section">
            <h2>🚀 Quick Solutions</h2>
            <div class="status info">
                <strong>Common XAMPP Issues:</strong><br>
                1. MySQL not starting: Check XAMPP Control Panel<br>
                2. Port conflict: Try changing MySQL port in XAMPP config<br>
                3. Database doesn't exist: Use the "Create Database" button above<br>
                4. No tables: Use the "Initialize Database" button above<br>
                5. Permission denied: Check MySQL user permissions
            </div>
            
            <div style="margin-top: 20px;">
                <a href="setup.php" class="btn">⚙️ Database Setup</a>
                <a href="test.php" class="btn">🧪 Connection Test</a>
                <a href="../index.php" class="btn">🏠 Back to App</a>
                <a href="?action=restart_check" class="btn btn-danger">🔄 Restart Check</a>
            </div>
        </div>

        <!-- Terminal Commands -->
        <div class="test-section">
            <h2>💻 Manual Terminal Commands</h2>
            <div class="status info">
                <strong>If you need to manually check MySQL:</strong><br><br>
                Check if MySQL is running:<br>
                <code>ps aux | grep mysql</code><br><br>
                
                Connect to MySQL:<br>
                <code>/Applications/XAMPP/xamppfiles/bin/mysql -u root</code><br><br>
                
                Create database:<br>
                <code>/Applications/XAMPP/xamppfiles/bin/mysql -u root -e "CREATE DATABASE myfinance;"</code><br><br>
                
                Initialize database:<br>
                <code>/Applications/XAMPP/xamppfiles/bin/mysql -u root myfinance < database/init.sql</code>
            </div>
        </div>
    </div>
</body>
</html>
