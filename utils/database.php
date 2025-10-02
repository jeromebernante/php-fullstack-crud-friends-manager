<?php
function getDatabaseConnection()
{
    $host = 'localhost';
    $dbname = 'friends_db';
    $username = 'root';
    $password = '';

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        // If DB not found, create it
        if (strpos($e->getMessage(), "Unknown database") !== false) {
            createDatabase($host, $username, $password, $dbname);
            return getDatabaseConnection(); // reconnect after creation
        }
        die("Database connection failed: " . $e->getMessage());
    }
}

function createDatabase($host, $username, $password, $dbname)
{
    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create DB if not exists
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` 
                    CHARACTER SET utf8mb4 
                    COLLATE utf8mb4_unicode_ci");

        // Connect to new DB
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create table if not exists
        $pdo->exec("CREATE TABLE IF NOT EXISTS friends (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            gender VARCHAR(50),
            phone VARCHAR(20),
            city VARCHAR(100),
            email VARCHAR(255),
            created_at DATE DEFAULT CURRENT_DATE
        )");

        // Optional seed data
        $stmt = $pdo->query("SELECT COUNT(*) FROM friends");
        if ($stmt->fetchColumn() == 0) {
            $pdo->exec("INSERT INTO friends (name, gender, phone, city, email, created_at) VALUES
                ('John Doe', 'Male', '555-123-4567', 'New York', 'john@example.com', CURDATE()),
                ('Jane Smith', 'Female', '555-987-6543', 'Los Angeles', 'jane@example.com', CURDATE()),
                ('Bob Johnson', 'Male', '555-555-5555', 'Chicago', 'bob@example.com', CURDATE())
            ");
        }

    } catch (PDOException $e) {
        die("Database creation failed: " . $e->getMessage());
    }
}
