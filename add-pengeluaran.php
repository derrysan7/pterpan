<?php
require_once "classes/class.crud.pengeluaran.php";
include_once "views/header.php";
$pengeluaran = new Pengeluaran();

if(isset($_POST['submit']))
{
    $userId = $userRow['userId'];
    $namaKomp = $_POST['namaKomp'];
    $persenKomp = $_POST['persenKomp'];

    if($pengeluaran->create($userId,$namaKomp, $persenKomp))
    {
        header("Location: add-pengeluaran.php?inserted");
    }
    else
    {
        header("Location: add-pengeluaran.php?failure");
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
            <strong>Berhasil!</strong> Data komponen pengeluaran berhasil ditambahkan. <a href="view-pengeluaran.php">Lihat daftar komponen pengeluaran</a>!
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


        <div class="col-md-6">
            <form class="form-horizontal" method="post">
                <fieldset class="form-group grouped">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="namaKomp">Komponen Pengeluaran</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" name="namaKomp[]" type="text" placeholder="Contoh: Transportasi" required>
                            <span class="input-group-addon">
          <span class="glyphicon glyphicon-list"></span>
        </span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="persenKomp">Batas Anggaran</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" name="persenKomp[]" type="number" placeholder="Contoh: 10" required>
                            <span class="input-group-addon">%</span>
                            </span>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 input-group">
                        <a href="#" class="btn btn-info copy" rel=".grouped">Tambah Komponen</a> &nbsp;
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

<?php include_once 'views/footer.php'; ?>