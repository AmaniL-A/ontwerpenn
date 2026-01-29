<?php

include_once __DIR__ . "/../config.php";

class Database {

    public static function connectDb() {
        try {
            $conn = new PDO(
                "mysql:host=" . SERVERNAME . ";dbname=" . DATABASE,
                USERNAME,
                PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch (PDOException $e) {
            die("Database fout: " . $e->getMessage());
        }
    }
}
