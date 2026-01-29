<?php
    // functie: formulier en database insert fiets
    // auteur: Vul hier je naam in
include_once "classes/Fiets.php";

$fiets = new Fiets();

if (isset($_POST['btn_ins'])) {
    if ($fiets->insertRecord($_POST)) {
        echo "<script>
            alert('Fiets toegevoegd');
            location.href='index.php';
        </script>";
    }
}
?>

<h1>Insert Fiets</h1>
<form method="post">
    Merk: <input type="text" name="merk" required><br>
    Type: <input type="text" name="type" required><br>
    Prijs: <input type="number" name="prijs" required><br>
    <button name="btn_ins">Opslaan</button>
</form>
