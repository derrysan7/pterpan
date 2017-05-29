<?php
include_once "classes/class.crud.pengeluaran.php";
$page=3;
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
if(isset($_GET['periode'])){
    $periode = explode("/",$_GET['periode']);
    $periode = $periode[0]."/01/".$periode[1];
    $periode = date('Y-m-d',strtotime($periode));
//    die(date('Y-m-d'));
}else{
    $periode = date('Y-m-d');
//    die(date('Y-m-d'));
}

if(isset($_POST['btn-periode'])){
    header("Location: view-pengeluaran.php?periode=".$_POST['periode']);
}

?>
    <link href="style/css/month-picker.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="style/js/month-picker.js"></script>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
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

            <div class="clearfix"></div>
            <form method="post">
                <button class="btn btn-large btn-info" name="btn-add" type="submit"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records </button>


                <hr>
                <div class="form form-horizontal">
                    <label class="col-md-1 control-label" for="periode">Periode</label>
                    <div class="col-md-2">
                        <input class="form-control date-picker" name="periode" readonly required value="<?php $dtp=explode("-",$periode); $dtp=$dtp[1]."/".$dtp[0]; echo $dtp?>">

                    </div>
                    <button class="btn btn-info" type="submit" name="btn-periode">Submit</button>

                </div>
            </form>

        </div>

        <div class="clearfix"></div><br />

        <div class="container">



            <h4>Sisa saldo Anda bulan ini =  <span style="color: #4bc32b;"><?php echo "Rp &nbsp;".number_format($pengeluaran->currentBalance($userRow['userId'],$periode),2,'.',','); ?></span></h4>

            <?php
            //        $query = "SELECT komppengeluaran.kompId,namaKomp,persenKomp,tipePngl,anggaranPngl Anggaran
            //FROM komppengeluaran,pengeluaran
            //WHERE userId=".$userRow['userId']."
            //AND komppengeluaran.kompId=pengeluaran.kompId
            //AND komppengeluaran.flag='0'
            //AND MONTH(komppengeluaran.tglKomp) = MONTH('".$periode."')
            //AND YEAR(komppengeluaran.tglKomp) = YEAR('".$periode."')
            //GROUP BY kompId
            //UNION
            //SELECT komppengeluaran.kompId,namaKomp,persenKomp,tipePngl,anggaranPngl Anggaran
            //FROM komppengeluaran,pengeluaran,cicilan
            //WHERE komppengeluaran.userId=".$userRow['userId']."
            //AND komppengeluaran.kompId=pengeluaran.kompId
            //AND komppengeluaran.kompId = cicilan.kompId
            //AND cicilan.flag='0'
            //AND komppengeluaran.flag='0'
            //AND tglSelesai >= '".$periode."'
            //AND tglMulai <= '".$periode."'
            //GROUP BY kompId";
            //        $query = "SELECT * FROM kompPengeluaran WHERE flag='0' AND MONTH(tglKomp) = MONTH(CURRENT_DATE) AND userId='".$userRow['userId']."'ORDER BY namaKomp ASC";
            $pengeluaran->dataview($periode,$userRow['userId']);
            ?>


        </div>

    </div>

<?php include_once 'views/footer.php'; ?>