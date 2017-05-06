<?php
require_once ("session.php");
include_once "classes/class.crud.pengeluaran.php";
$pengeluaran = new Pengeluaran();
include_once "classes/Penghasilan.php";
$penghasilan = new Penghasilan();
$userId = $_SESSION['user_session'];

$tot_peng = $penghasilan->tot_penghasilan($userId);

$results = $pengeluaran->json_chart_persen($userId,$tot_peng['nomPenghasilan']);
print json_encode($results,JSON_NUMERIC_CHECK);
?>