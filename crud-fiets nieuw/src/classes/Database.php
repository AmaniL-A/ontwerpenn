<?php
namespace App;

use PDO;

class Database {
    private PDO $connection;

    public function __construct() {
        // Config laden
        require __DIR__ . '/../config.php';

        $this->connection = new PDO(
            "mysql:host=" . SERVERNAME . ";dbname=" . DATABASE . ";charset=utf8",
            USERNAME,
            PASSWORD
        );

        // Zorg dat PDO exceptions gooit bij fouten
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}
