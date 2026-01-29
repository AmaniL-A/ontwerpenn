<?php
include_once "classes/Fiets.php";
$fiets = new Fiets();

if (isset($_POST['btn_wzg'])) {
    $fiets->updateRecord($_POST);
    header("Location: index.php");
}

if (!isset($_GET['id'])) {
    die("Geen ID");
}

$row = $fiets->getRecord($_GET['id']);
?>

<h1>Wijzig Fiets</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    Merk: <input type="text" name="merk" value="<?= $row['merk'] ?>"><br>
    Type: <input type="text" name="type" value="<?= $row['type'] ?>"><br>
    Prijs: <input type="number" name="prijs" value="<?= $row['prijs'] ?>"><br>
    <button name="btn_wzg">Wijzig</button>
</form>
