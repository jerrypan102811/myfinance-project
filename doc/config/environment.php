<?php
/**
 * Environment Configuration
 * Copy this file to create environment-specific settings
 */

// Development environment settings
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development'); // development, staging, production
}

// Environment-specific database settings
switch (ENVIRONMENT) {
    case 'development':
        // These will be overridden by database.php, but kept for reference
        $dev_host = 'localhost';
        $dev_name = 'myfinance';
        $dev_user = 'root';
        $dev_pass = '';
        define('DEBUG_MODE', true);
        break;
        
    case 'staging':
        $staging_host = 'staging-host';
        $staging_name = 'myfinance_staging';
        $staging_user = 'staging_user';
        $staging_pass = 'staging_password';
        define('DEBUG_MODE', true);
        break;
        
    case 'production':
        $prod_host = 'production-host';
        $prod_name = 'myfinance_prod';
        $prod_user = 'prod_user';
        $prod_pass = 'secure_password';
        define('DEBUG_MODE', false);
        break;
}

// Adjust error reporting based on environment
if (defined('DEBUG_MODE') && DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
