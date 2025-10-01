<?php
function getDatabaseConnection()
{
    $host = 'localhost';
    $dbname = 'friends_db';
    $username = 'root'; 
    $password = '';

    // Step 1: Connect to MySQL server
    try {
        $dsn = "mysql:host=$host;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if database exists
        $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
        $databaseExists = $stmt->fetch();

        if (!$databaseExists) {
            // Create database if it doesn't exist
            $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }

        // Step 2: Connect to the specific database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Step 3: Check if friends table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'friends'");
        $tableExists = $stmt->fetch();

        if (!$tableExists) {
            // Create friends table
            $pdo->exec("CREATE TABLE friends (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    gender VARCHAR(50),
                    phone VARCHAR(20),
                    city VARCHAR(100),
                    email VARCHAR(255),
                    created_at DATE
                )
            ");

            // Insert sample data
            $pdo->exec("INSERT INTO friends (name, gender, phone, city, email, created_at) VALUES
                ('John Doe', 'Male', '555-123-4567', 'New York', 'john@example.com', '2025-10-01'),
                ('Jane Smith', 'Female', '555-987-6543', 'Los Angeles', 'jane@example.com', '2025-09-15'),
                ('Bob Johnson', 'Male', '555-555-5555', 'Chicago', 'bob@example.com', '2025-08-20')
            ");
        }

        return $pdo;
    } catch (PDOException $e) {
        error_log("Database setup failed: " . $e->getMessage());
        include "../utils/functions.php";
        exit(render("../pages/404.php"));
    }
}
?>