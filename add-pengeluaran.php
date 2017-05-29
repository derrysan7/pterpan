<?php
require_once "classes/class.crud.pengeluaran.php";
$page=3;
include_once "views/header.php";

$pengeluaran = new Pengeluaran();
if(isset($_POST['submit']))
{
    $tgl = explode("/",$_POST['tglKomp']);
    $tglFormat = $tgl[0]."/01/".$tgl[1];
    $tglFormat=date('Y-m-d',strtotime($tglFormat));
    $userId = $userRow['userId'];
    $namaKomp = $_POST['namaKomp'];
    $persenKomp = $_POST['persenKomp'];
    $tipePngl = isset($_POST['tipePngl']);
    $tglKomp = $tglFormat;




    if($pengeluaran->create($userId,$namaKomp,$tipePngl,$tglKomp,$persenKomp)){
        header("Location: add-pengeluaran.php?inserted");
    } else {
        header("Location: add-pengeluaran.php?full");
    }
}
?>
    <link href="style/css/month-picker.css" rel="stylesheet" type="text/css">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="clearfix"></div>

        <?php
        if(isset($_GET['inserted']))
        {
            ?>
            <div class="container">
                <div class="alert alert-info">
                    <strong>Berhasil!</strong> Data komponen pengeluaran berhasil ditambahkan. <a href="view-pengeluaran.php">Lihat daftar komponen pengeluaran</a>!
                </div>
            </div>
            <?php
        }
        else if(isset($_GET['full']))
        {
            ?>
            <div class="container">
                <div class="alert alert-warning">
                    <strong>Maaf</strong>, anda memasukkan data persen yang menyebabkan total persentase komponen pengeluaran anda lebih dari 100%.
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
            <h1>Tambah Komponen Pengeluaran</h1>
            <hr>

            <div class="col-md-6">
                <form class="form-horizontal" method="post">
                    <fieldset class="form-group grouped">
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="namaKomp">Komponen Pengeluaran</label>
                            <div class="col-sm-8 input-group">
                                <input class="form-control" name="namaKomp" type="text" placeholder="Contoh: Transportasi" maxlength="15" required>
                                <span class="input-group-addon">
          <span class="glyphicon glyphicon-list"></span>
        </span>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="persenKomp">Batas Anggaran</label>
                            <div class="col-sm-8 input-group">
                                <input class="form-control" name="persenKomp" placeholder="Contoh: 10" onkeypress="return isNumberKey(event)" required>
                                <span class="input-group-addon">%</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="tglKomp">Periode</label>
                            <div class="col-sm-8 input-group">
                                <input class="form-control date-picker" name="tglKomp" value="<?php $currentTglKomp = date('m/Y'); echo $currentTglKomp?>" readonly required>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4"></div>
                            <div class="col-sm-8 input-group checkbox">
                                <label><input name="tipePngl" type="checkbox" value=true>
                                    Cicilan</label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-8 input-group">
                            <!--                        <a href="#" class="btn btn-info copy" rel=".grouped">Tambah Komponen</a> &nbsp;-->
                            <button class="btn btn-primary" name="submit" type="submit">
                                <span class="glyphicon glyphicon-plus"></span> &nbsp; Simpan
                            </button>
                            <!--                        <input type="submit" class="btn btn-primary" name="submit" value="Simpan">--> &nbsp;
                            <a href="view-pengeluaran.php" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Kembali</a>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

<?php include_once 'views/footer.php'; ?>