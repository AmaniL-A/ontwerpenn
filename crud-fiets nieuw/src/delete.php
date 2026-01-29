<?php
include_once "classes/Fiets.php";

$fiets = new Fiets();

if (isset($_GET['id'])) {
    $fiets->deleteRecord($_GET['id']);
    header("Location: index.php");
}
