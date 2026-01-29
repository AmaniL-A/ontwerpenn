<?php

include_once __DIR__ . "/Database.php";
include_once __DIR__ . "/../config.php";

class Fiets {

    public function crudMain() {
        echo "
        <h1>Crud Fietsen</h1>
        <nav>
            <a href='insert.php'>Toevoegen nieuwe fiets</a>
        </nav><br>";

        $result = $this->getData();
        $this->printCrudTabel($result);
    }

    public function getData(): array {
        $conn = Database::connectDb();
        $stmt = $conn->prepare("SELECT * FROM " . CRUD_TABLE);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRecord($id) {
        $conn = Database::connectDb();
        $stmt = $conn->prepare(
            "SELECT * FROM " . CRUD_TABLE . " WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function insertRecord(array $post): bool {
        $conn = Database::connectDb();
        $sql = "
            INSERT INTO " . CRUD_TABLE . " (merk, type, prijs)
            VALUES (:merk, :type, :prijs)
        ";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':merk' => $post['merk'],
            ':type' => $post['type'],
            ':prijs' => $post['prijs']
        ]);
    }

    public function updateRecord(array $post): bool {
        $conn = Database::connectDb();
        $sql = "
            UPDATE " . CRUD_TABLE . "
            SET merk = :merk, type = :type, prijs = :prijs
            WHERE id = :id
        ";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':merk' => $post['merk'],
            ':type' => $post['type'],
            ':prijs' => $post['prijs'],
            ':id'   => $post['id']
        ]);
    }

    public function deleteRecord($id): bool {
        $conn = Database::connectDb();
        $stmt = $conn->prepare(
            "DELETE FROM " . CRUD_TABLE . " WHERE id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    private function printCrudTabel(array $result) {
        echo "<table border='1'><tr>";

        foreach (array_keys($result[0]) as $header) {
            echo "<th>$header</th>";
        }
        echo "<th colspan='2'>Actie</th></tr>";

        foreach ($result as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>$cell</td>";
            }
            echo "
            <td><a href='update.php?id={$row['id']}'>Wzg</a></td>
            <td><a href='delete.php?id={$row['id']}'>Verwijder</a></td>
            </tr>";
        }
        echo "</table>";
    }
}
