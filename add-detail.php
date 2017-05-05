<?php
require_once "classes/class.crud.pengeluaran.php";
include_once "views/header.php";
$pengeluaran = new Pengeluaran();

if(empty($_GET['anggaran_id'])){
    exit("Page not found!");
}elseif (isset($_GET['anggaran_id'])){
    $id = $_GET['anggaran_id'];
    extract($pengeluaran->getdetaileditID($id));
    if ($namaKomp === null) {
        exit("Page not found!");
    } elseif ($userId != $userRow['userId']) {
        exit("Page not found!");
    }
}

if(isset($_POST['submit']))
{
    $pengeluaranId = $id;
    $namaDtlPngl   = $_POST['namaDtlPngl'];
    $jmlDtlPngl    = $_POST['jmlDtlPngl'];
    $tglDtlPngl    = $_POST['tglDtlPngl'];

    if($pengeluaran->createDetail($pengeluaranId,$namaDtlPngl,$jmlDtlPngl,$tglDtlPngl))
    {
        header("Location: add-detail.php?anggaran_id=".$id."&inserted");
    }
    else
    {
        header("Location: add-detail.php?anggaran_id=".$id."&failure");
    }
}



?>

    <div class="clearfix"></div>

<?php

if(isset($_GET['inserted']))
{
    ?>
    <div class="container">
        <div class="alert alert-info">
            <strong>Berhasil!</strong> Data pengeluaran harian berhasil ditambahkan. <a href="view-anggaran.php?kom_id=<?php echo $kompId?>">Lihat daftar pengeluaran anggaran</a>!
        </div>
    </div>
    <?php
    }
else if(isset($_GET['failure']))
{
    ?>
    <div class="container">
        <div class="alert alert-warning">
            <strong>Maaf</strong>, terjadi kesalahan saat menambahkan data.
        </div>
    </div>
    <?php
}
?>

    <div class="clearfix"></div><br />

    <div class="container">
        <h1>Tambah Pengeluaran Harian <?php echo $namaKomp?></h1>
        <hr>

        <div class="col-md-6">
            <form class="form-horizontal" method="post">

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="namaDtlPngl">Nama Pengeluaran</label>
                    <div class="col-sm-8 input-group">
                        <input class="form-control" name="namaDtlPngl" type="text" placeholder="Contoh: Makan siang" required>
                        <span class="input-group-addon">
          <span class="glyphicon glyphicon-list"></span>
        </span>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="jmlDtlPngl">Nominal Pengeluaran</label>
                    <div class="col-sm-8 input-group">
                        <span class="input-group-addon">Rp</span>
                        <input class="form-control" name="jmlDtlPngl" type="number" placeholder="Contoh: 250000" required>

                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="tglDtlPngl">Tanggal</label>
                    <div class="col-sm-8 input-group">
                        <input class="form-control" name="tglDtlPngl" type="date" required>
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 input-group">
                        <!--                        <a href="#" class="btn btn-info copy" rel=".grouped">Tambah Komponen</a> &nbsp;-->
                        <button class="btn btn-primary" name="submit" type="submit">
                            <span class="glyphicon glyphicon-plus"></span> &nbsp; Simpan
                        </button>
                        <!--                        <input type="submit" class="btn btn-primary" name="submit" value="Simpan">--> &nbsp;
                        <a href="view-anggaran.php?kom_id=<?php echo $kompId ?>" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Kembali</a>
                    </div>
                </div>

            </form>
        </div>


    </div>

<?php include_once 'views/footer.php'; ?>