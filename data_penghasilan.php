<?php
require_once ("session.php");
include_once "classes/Penghasilan.php";
$penghasilan = new Penghasilan();
$userId = $_SESSION['user_session'];
$results = $penghasilan->json_chart($userId);
print json_encode($results,JSON_NUMERIC_CHECK);
?>