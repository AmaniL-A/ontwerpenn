<?php
namespace App\Models;

use PDO;

class Fiets {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Maak een nieuwe fiets aan
    public function create(string $merk, string $type, float $prijs): int {
        $stmt = $this->db->prepare("INSERT INTO " . CRUD_TABLE . " (merk, type, prijs) VALUES (:merk, :type, :prijs)");
        $stmt->execute([
            ':merk' => $merk,
            ':type' => $type,
            ':prijs' => $prijs
        ]);
        return (int)$this->db->lastInsertId();
    }

    // Haal één fiets op
    public function read(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM " . CRUD_TABLE . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Haal alle fietsen op
    public function readAll(): array {
        $stmt = $this->db->query("SELECT * FROM " . CRUD_TABLE);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update een fiets
    public function update(int $id, string $merk, string $type, float $prijs): bool {
        $stmt = $this->db->prepare("UPDATE " . CRUD_TABLE . " SET merk = :merk, type = :type, prijs = :prijs WHERE id = :id");
        return $stmt->execute([
            ':merk' => $merk,
            ':type' => $type,
            ':prijs' => $prijs,
            ':id' => $id
        ]);
    }

    // Verwijder een fiets
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM " . CRUD_TABLE . " WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
