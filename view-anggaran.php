<?php
include_once "classes/class.crud.pengeluaran.php";
$page=3;
include_once "views/header.php";
$pengeluaran = new Pengeluaran();



if(empty($_GET['kom_id'])){
    exit("Page not found!");
}elseif (isset($_GET['kom_id'])){
    $id = $_GET['kom_id'];
    extract($pengeluaran->getAnggaranID($id));
    if ($namaKomp === null) {
        exit("Page not found!");
    } elseif ($userId != $userRow['userId']) {
        exit("Page not found!");
    }

}
if (isset($_POST['btn-add'])){
    header("Location: add-detail.php?anggaran_id=".$pengeluaranId);
}

//if(isset($_GET['kom_id'])){
//    $id = $_GET['kom_id'];
//    extract($pengeluaran->getdetailID($id));
//}



$periodePngl = new DateTime($tglKomp);

?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="clearfix"></div>

        <div class="container">
            <h1>Anggaran <?php echo ucwords($namaKomp); ?></h1>
            <hr>
            <h6>Summary :</h6>
            <div class="col-md-6">
                <table class='table  table-responsive '>
                    <tr>
                        <td class="col-md-2">Nama Komponen Anggaran</td>

                        <td class="col-md-4">: &nbsp;<?php echo ucwords($namaKomp); ?></td>
                    </tr>
                    <tr>
                        <td class="col-md-2">Periode Anggaran</td>

                        <td class="col-md-4">: &nbsp;<?php print date_format($periodePngl,"F Y"); ?></td>
                    </tr>
                    <tr>
                        <td class="col-md-2">Nominal Anggaran</td>

                        <td class="col-md-4">: &nbsp;<?php print 'Rp &nbsp;'.number_format($anggaranPngl,2,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href="view-pengeluaran.php" class="btn btn-info btn-xs">Daftar Komponen Pengeluaran</a>
                            <a href="edit-anggaran.php?pngl_id=<?php print($pengeluaranId); ?>" class="btn btn-warning btn-xs">Ubah</a>&nbsp;
                        </td>
                    </tr>
                </table>
            </div>

        </div>



        <div class="container">
            <hr>
            <form method="post">
                <button class="btn btn-large btn-info" name="btn-add" type="submit"><i class="glyphicon glyphicon-plus"></i> &nbsp;
                    Add Records </button>

            </form>
        </div>

        <div class="clearfix"></div><br />

        <div class="container">
            <table class='table table-bordered table-responsive'>
                <tr>
                    <th>#</th>
                    <th>Pengeluaran</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th colspan="2" align="center">Actions</th>
                </tr>
                <?php
                $query = "SELECT * FROM komppengeluaran , detailpengeluaran , pengeluaran 
                                              WHERE komppengeluaran.kompId='".$kompId."' AND 
                                              pengeluaran.kompId='".$kompId."' AND 
                                              detailpengeluaran.pengeluaranId=pengeluaran.pengeluaranId AND
                                              detailpengeluaran.flag='0'";
                //        $records_per_page=5;
                //        $newquery = $pengeluaran->paging($query,$records_per_page);

                $pengeluaran->datadetailanggaranview($query);
                ?>
            </table>

        </div>

    </div>

<?php include_once 'views/footer.php'; ?>