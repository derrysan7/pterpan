<?php
require_once ("session.php");
include_once "classes/class.crud.pengeluaran.php";
$pengeluaran = new Pengeluaran();
$userId = $_SESSION['user_session'];
$results = $pengeluaran->json_chart($userId);
print json_encode($results,JSON_NUMERIC_CHECK);
?>