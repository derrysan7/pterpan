<?php
require_once ("session.php");
include_once "classes/class.crud.pengeluaran.php";
$pengeluaran = new Pengeluaran();
$userId = $_SESSION['user_session'];
if(isset($_GET['selected_month']) == "")
    {
        $date_now = date("Y-m-t");
    }
    elseif(empty($_GET['selected_month'])) 
    { 
      $date_now = date("Y-m-t");
    }
    elseif(isset($_GET['selected_month']))
    {
        $date_object = new DateTime("20-".$_GET['selected_month']);       
        $date_now = $date_object->format("Y-m-t");
    }

    $month_now = substr($date_now,5,2);
    $year_now = substr($date_now,0,4);
$results = $pengeluaran->json_chart($userId,$date_now,$month_now,$year_now);
print json_encode($results,JSON_NUMERIC_CHECK);
?>