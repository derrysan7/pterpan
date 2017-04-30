<?php
include_once "classes/class.crud.pengeluaran.php";
include_once "views/header.php";
$pengeluaran = new Pengeluaran();

if (isset($_POST['btn-add'])){
    if ($pengeluaran->Pghsisset($userRow['userId'])){
        header("Location: add-pengeluaran.php");
    }else{
        header("Location: index.php");
    }
}


?>

    <div class="clearfix"></div>

    <div class="container">
        <h1>Komponen Pengeluaran</h1>
        <hr>

    <form method="post">
        <button class="btn btn-large btn-info" name="btn-add" type="submit"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records </button>

    </form>
    </div>

    <div class="clearfix"></div><br />

    <div class="container">

            <?php
            $query = "SELECT * FROM kompPengeluaran WHERE flag='0' AND userId='".$userRow['userId']."'ORDER BY namaKomp ASC";
            $records_per_page=5;
            $newquery = $pengeluaran->paging($query,$records_per_page);
            $pengeluaran->dataview($query);
            ?>



    </div>

<?php include_once 'views/footer.php'; ?>