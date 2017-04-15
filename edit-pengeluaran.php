<?php
require_once "classes/class.crud.pengeluaran.php";
$pengeluaran = new Pengeluaran();

if(isset($_POST['submit']))
{
    $kompId = $_GET['edit_id'];
    $namaKomp = $_POST['namaKomp'];
    $persenKomp = $_POST['persenKomp'];


    if($pengeluaran->update($kompId,$namaKomp,$persenKomp))
    {
        $msg= "<div class='alert alert-info'><strong>Berhasil!</strong> Data pengeluaran berhasil diperbaharui. <a href='view-pengeluaran.php'>Lihat daftar pengeluaran</a>!</div>";
    }
    else
    {
        $msg="<div class='alert alert-warning'>
            <strong>Maaf</strong>, terjadi kesalahan saat memperbaharui data.
        </div>";
    }
}
if(isset($_GET['edit_id']))
{
    $id = $_GET['edit_id'];
    extract($pengeluaran->getID($id));
}
?>

<?php include_once "views/header.php"; ?>


    <div class="container">

        <?php
        if (isset($msg)){
            echo $msg;
        }
        ?>

        <div class="col-md-6">
            <form class="form-horizontal" method="post">

                <fieldset class="form-group grouped">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="namaKomp">Komponen Pengeluaran</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" name="namaKomp" type="text" value="<?php echo $namaKomp ?>" placeholder="Contoh: Transportasi" required>
                            <span class="input-group-addon">
          <span class="glyphicon glyphicon-list"></span>
        </span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="persenKomp">Batas Anggaran</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" name="persenKomp" type="number" value="<?php echo $persenKomp ?>" placeholder="Contoh: 10" required>
                            <span class="input-group-addon">%</span>
                            </span>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 input-group">
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