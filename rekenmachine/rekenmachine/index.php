<?php
require_once 'classes/Rekenmachine.php';

$calc= new Rekenmachine ();
echo "Uitkomst: " . $calc->optellen(3,4);
//var_dump($calc);
?>