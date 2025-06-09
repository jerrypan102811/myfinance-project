<?php
/**
 * Database Configuration for MyFinance Application
 * Centralized database settings and connection management
 */

// Load database credentials from separate config file
require_once __DIR__ . '/database_config.php';

// Application settings
define('APP_NAME', 'MyFinance');
define('APP_VERSION', '1.0.0');
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds

// Error reporting configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Database Connection Class
 */
class DatabaseConnection {
    private static $pdo = null;
    private static $mysqli = null;
    
    /**
     * Get PDO connection instance (singleton pattern)
     */
    public static function getPDO() {
        if (self::$pdo === null) {
            try {
                $port = defined('DB_PORT') ? DB_PORT : 3306;
                $dsn = "mysql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_PERSISTENT => false
                ];
                
                // Add SSL options if configured
                if (defined('DB_SSL_ENABLED') && DB_SSL_ENABLED) {
                    if (defined('DB_SSL_CERT')) $options[PDO::MYSQL_ATTR_SSL_CERT] = DB_SSL_CERT;
                    if (defined('DB_SSL_KEY')) $options[PDO::MYSQL_ATTR_SSL_KEY] = DB_SSL_KEY;
                    if (defined('DB_SSL_CA')) $options[PDO::MYSQL_ATTR_SSL_CA] = DB_SSL_CA;
                    $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
                }
                
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
                
            } catch(PDOException $e) {
                error_log("Database PDO connection failed: " . $e->getMessage());
                die("Database connection failed. Please check your configuration in /config/database_config.php");
            }
        }
        return self::$pdo;
    }
    
    /**
     * Get MySQLi connection instance (for backward compatibility)
     */
    public static function getMySQLi() {
        if (self::$mysqli === null) {
            try {
                $port = defined('DB_PORT') ? DB_PORT : 3306;
                self::$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, $port);
                if (self::$mysqli->connect_error) {
                    throw new Exception("MySQLi connection failed: " . self::$mysqli->connect_error);
                }
                self::$mysqli->set_charset(DB_CHARSET);
            } catch (Exception $e) {
                error_log("Database MySQLi connection failed: " . $e->getMessage());
                die("Database connection failed. Please check your configuration in /config/database_config.php");
            }
        }
        return self::$mysqli;
    }
    
    /**
     * Test database connection
     */
    public static function testConnection() {
        try {
            $pdo = self::getPDO();
            $stmt = $pdo->query("SELECT 1");
            return $stmt !== false;
        } catch (Exception $e) {
            error_log("Database connection test failed: " . $e->getMessage());
            return false;
        }
    }
}

// Initialize global connection variables for backward compatibility
try {
    $pdo = DatabaseConnection::getPDO();
    $mysqli = DatabaseConnection::getMySQLi();
} catch (Exception $e) {
    error_log("Failed to initialize database connections: " . $e->getMessage());
    die("Database initialization failed.");
}
?>
