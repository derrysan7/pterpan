<?php
include_once "classes/class.crud.pengeluaran.php";
include_once "views/header.php";
$pengeluaran = new Pengeluaran();
$Pghsisset = false;

if (isset($_POST['btn-add'])){
    if ($pengeluaran->Pghsisset($userRow['userId'])){
        $Pghsisset = false;
        header("Location: add-pengeluaran.php");
    }else{
        $Pghsisset = true;
//        header("Location: index.php");
    }
}

?>

    <div class="clearfix"></div>

    <div class="container">
        <h1>Komponen Pengeluaran</h1>
        <hr>
        <?php
        if($Pghsisset){
            ?>
            <div class="container">
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan!</strong> Anda belum memasukkan data penghasilan pada bulan <?php echo date('F') ?>, silakan isi penghasilan Anda <a href="add-penghasilan.php">di sini</a>!
                </div>
            </div>
            <?php
        }
        ?>

        <form method="post">
            <button class="btn btn-large btn-info" name="btn-add" type="submit"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records </button>

        </form>
    </div>

    <div class="clearfix"></div><br />

    <div class="container">



            <h4>Sisa saldo Anda bulan ini =  <span style="color: #4bc32b;"><?php echo "Rp &nbsp;".number_format($pengeluaran->currentBalance($userRow['userId']),2,'.',','); ?></span></h4>

        <div class="clearfix"></div>

        <?php
        $query = "SELECT * FROM kompPengeluaran WHERE flag='0' AND MONTH(tglKomp) = MONTH(CURRENT_DATE) AND userId='".$userRow['userId']."'ORDER BY namaKomp ASC";
        $records_per_page=5;
        $newquery = $pengeluaran->paging($query,$records_per_page);
        $pengeluaran->dataview($query);
        ?>



    </div>

<?php include_once 'views/footer.php'; ?>