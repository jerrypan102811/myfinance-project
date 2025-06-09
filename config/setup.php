<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Configuration Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .config-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn {
            background: #28a745;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn:hover {
            background: #218838;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .preset-btn {
            background: #17a2b8;
            margin: 5px;
            padding: 8px 16px;
            font-size: 12px;
        }
        .preset-btn:hover {
            background: #138496;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-info {
            background: rgba(23, 162, 184, 0.3);
            border: 2px solid #17a2b8;
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.3);
            border: 2px solid #28a745;
        }
        .alert-danger {
            background: rgba(220, 53, 69, 0.3);
            border: 2px solid #dc3545;
        }
    </style>
</head>
<body>
    <div class="config-container">
        <h1>🔧 Database Configuration Setup</h1>
        <p>Configure your database connection settings for MyFinance</p>

        <?php
        $configFile = __DIR__ . '/database_config.php';
        $message = '';
        $messageType = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $host = $_POST['host'] ?? 'localhost';
            $port = $_POST['port'] ?? '3306';
            $database = $_POST['database'] ?? 'myfinance';
            $username = $_POST['username'] ?? 'root';
            $password = $_POST['password'] ?? '';

            $configContent = "<?php\n";
            $configContent .= "/**\n";
            $configContent .= " * Database Credentials Configuration\n";
            $configContent .= " * Generated on " . date('Y-m-d H:i:s') . "\n";
            $configContent .= " */\n\n";
            $configContent .= "// Database connection credentials\n";
            $configContent .= "define('DB_HOST', '" . addslashes($host) . "');\n";
            $configContent .= "define('DB_NAME', '" . addslashes($database) . "');\n";
            $configContent .= "define('DB_USER', '" . addslashes($username) . "');\n";
            $configContent .= "define('DB_PASS', '" . addslashes($password) . "');\n";
            $configContent .= "define('DB_PORT', " . intval($port) . ");\n";
            $configContent .= "define('DB_CHARSET', 'utf8mb4');\n";
            $configContent .= "?>";

            if (file_put_contents($configFile, $configContent)) {
                $message = "✅ Configuration saved successfully! You can now test your connection.";
                $messageType = 'success';
            } else {
                $message = "❌ Failed to save configuration. Please check file permissions.";
                $messageType = 'danger';
            }
        }

        // Load existing config if it exists
        $currentConfig = [
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'myfinance',
            'username' => 'root',
            'password' => ''
        ];

        if (file_exists($configFile)) {
            $configContent = file_get_contents($configFile);
            if (preg_match("/define\('DB_HOST',\s*'([^']+)'\)/", $configContent, $matches)) {
                $currentConfig['host'] = $matches[1];
            }
            if (preg_match("/define\('DB_PORT',\s*(\d+)\)/", $configContent, $matches)) {
                $currentConfig['port'] = $matches[1];
            }
            if (preg_match("/define\('DB_NAME',\s*'([^']+)'\)/", $configContent, $matches)) {
                $currentConfig['database'] = $matches[1];
            }
            if (preg_match("/define\('DB_USER',\s*'([^']+)'\)/", $configContent, $matches)) {
                $currentConfig['username'] = $matches[1];
            }
            if (preg_match("/define\('DB_PASS',\s*'([^']*)'\)/", $configContent, $matches)) {
                $currentConfig['password'] = $matches[1];
            }
        }

        if ($message) {
            echo "<div class='alert alert-$messageType'>$message</div>";
        }
        ?>

        <div class="alert alert-info">
            <strong>Quick Presets:</strong><br>
            <button class="btn preset-btn" onclick="setXAMPP()">XAMPP Default</button>
            <button class="btn preset-btn" onclick="setMAMP()">MAMP Default</button>
            <button class="btn preset-btn" onclick="setWAMP()">WAMP Default</button>
        </div>

        <form method="POST">
            <div class="form-group">
                <label for="host">Database Host:</label>
                <input type="text" id="host" name="host" value="<?php echo htmlspecialchars($currentConfig['host']); ?>" required>
            </div>

            <div class="form-group">
                <label for="port">Database Port:</label>
                <input type="number" id="port" name="port" value="<?php echo htmlspecialchars($currentConfig['port']); ?>" required>
            </div>

            <div class="form-group">
                <label for="database">Database Name:</label>
                <input type="text" id="database" name="database" value="<?php echo htmlspecialchars($currentConfig['database']); ?>" required>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($currentConfig['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($currentConfig['password']); ?>" placeholder="Leave empty if no password">
            </div>

            <button type="submit" class="btn">💾 Save Configuration</button>
            <a href="test.php" class="btn btn-secondary">🧪 Test Connection</a>
            <a href="../index.php" class="btn btn-secondary">🏠 Back to App</a>
        </form>

        <div style="margin-top: 30px; padding: 20px; background: rgba(0,0,0,0.2); border-radius: 8px;">
            <h3>📝 Current Configuration:</h3>
            <p><strong>Host:</strong> <?php echo htmlspecialchars($currentConfig['host']); ?></p>
            <p><strong>Port:</strong> <?php echo htmlspecialchars($currentConfig['port']); ?></p>
            <p><strong>Database:</strong> <?php echo htmlspecialchars($currentConfig['database']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($currentConfig['username']); ?></p>
            <p><strong>Password:</strong> <?php echo $currentConfig['password'] ? '••••••••' : '(none)'; ?></p>
        </div>
    </div>

    <script>
        function setXAMPP() {
            document.getElementById('host').value = 'localhost';
            document.getElementById('port').value = '3306';
            document.getElementById('database').value = 'myfinance';
            document.getElementById('username').value = 'root';
            document.getElementById('password').value = '';
        }

        function setMAMP() {
            document.getElementById('host').value = 'localhost';
            document.getElementById('port').value = '8889';
            document.getElementById('database').value = 'myfinance';
            document.getElementById('username').value = 'root';
            document.getElementById('password').value = 'root';
        }

        function setWAMP() {
            document.getElementById('host').value = 'localhost';
            document.getElementById('port').value = '3306';
            document.getElementById('database').value = 'myfinance';
            document.getElementById('username').value = 'root';
            document.getElementById('password').value = '';
        }
    </script>
</body>
</html>
