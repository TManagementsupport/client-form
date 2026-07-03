<?php
require_once __DIR__ . '/bootstrap.php';

function getPDO(): PDO {
    $databaseUrl = env_value('DATABASE_URL');

    if ($databaseUrl) {
        $parts = parse_url($databaseUrl);
        $scheme = $parts['scheme'] ?? 'pgsql';
        $host = $parts['host'] ?? 'localhost';
        $port = $parts['port'] ?? (($scheme === 'mysql') ? 3306 : 5432);
        $dbname = isset($parts['path']) ? ltrim($parts['path'], '/') : '';
        $user = $parts['user'] ?? '';
        $pass = $parts['pass'] ?? '';

        if (str_starts_with($scheme, 'postgres')) {
            return new PDO("pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    $driver = env_value('DB_DRIVER', 'mysql');
    $host = env_value('DB_HOST', 'localhost');
    $port = env_value('DB_PORT', $driver === 'mysql' ? 3306 : 5432);
    $dbname = env_value('DB_NAME', 'client_form_db');
    $user = env_value('DB_USER', 'root');
    $pass = env_value('DB_PASS', '');

    if ($driver === 'pgsql') {
        return new PDO("pgsql:host={$host};port={$port};dbname={$dbname}", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    return new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

function createClientsTable(PDO $pdo): void {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

    if ($driver === 'pgsql') {
        $pdo->exec("CREATE TABLE IF NOT EXISTS clients (
            id SERIAL PRIMARY KEY,
            nom_complet VARCHAR(150) NOT NULL,
            age VARCHAR(255) NOT NULL,
            date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    } else {
        $pdo->exec("CREATE TABLE IF NOT EXISTS clients (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom_complet VARCHAR(150) NOT NULL,
            age VARCHAR(255) NOT NULL,
            date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
}