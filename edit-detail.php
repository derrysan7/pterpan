<?php
require_once "classes/class.crud.pengeluaran.php";
$page=3;
include_once "views/header.php";
$pengeluaran = new Pengeluaran();

if(empty($_GET['edit_id'])){
    exit("Page not found!");
}elseif (isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    extract($pengeluaran->getdetaileditID($id));
    if ($namaKomp === null) {
        exit("Page not found!");
    }
    elseif ($userId != $userRow['userId']) {
        exit("Page not found!");
    }
}

if(isset($_POST['submit']))
{
    $detailPnglId = $_GET['edit_id'];
    $namaDtlPngl   = $_POST['namaDtlPngl'];
    $jmlDtlPngl    = $_POST['jmlDtlPngl'];
    $tglDtlPngl    = $_POST['tglDtlPngl'];

    if($pengeluaran->updateDetail($userRow['userId'],$detailPnglId,$namaDtlPngl,$jmlDtlPngl,$tglDtlPngl))
    {
        $msg= "<div class='alert alert-info'><strong>Berhasil!</strong> Data pengeluaran harian berhasil diperbaharui. <a href='view-anggaran.php?kom_id=$kompId'>Kembali</a>!</div>";
    }
    else
    {
        $msg="<div class='alert alert-warning'>
            <strong>Maaf</strong>, terjadi kesalahan saat menambahkan data. Saldo Anda tidak mencukupi.
        </div>";    }
}



?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="clearfix"></div>



        <div class="clearfix"></div><br />

        <div class="container">
            <h1>Edit Pengeluaran Harian <?php echo $namaKomp?></h1>
            <hr>
            <?php
            if (isset($msg)){
                echo $msg;
            }
            ?>
            <div class="col-md-6">
                <form class="form-horizontal" method="post">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="namaDtlPngl">Nama Pengeluaran</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" name="namaDtlPngl" type="text" placeholder="Contoh: Makan siang"
                                   value="<?php echo $namaDtlPngl ?>" required maxlength="15">
                            <span class="input-group-addon">
          <span class="glyphicon glyphicon-list"></span>
        </span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="jmlDtlPngl">Nominal Pengeluaran</label>
                        <div class="col-sm-8 input-group">
                            <span class="input-group-addon">Rp</span>
                            <input class="form-control" name="jmlDtlPngl" type="number" placeholder="Contoh: 250000"
                                   value="<?php echo $jmlDtlPngl ?>" required>

                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="tglDtlPngl">Tanggal</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" name="tglDtlPngl" type="date"
                                   value="<?php echo $tglDtlPngl ?>" required>
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
    </div>

<?php include_once 'views/footer.php'; ?>