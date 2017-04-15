<?php
require_once "classes/Penghasilan.php";
$penghasilan = new Penghasilan();

if(isset($_POST['submit']))
{
    $penghasilanId = $_GET['edit_id'];
    $tglPghs = $_POST['tglPghs'];
    $sumberPghs = $_POST['sumberPghs'];
    $nominalPghs = $_POST['nominalPghs'];

    if($penghasilan->update($penghasilanId,$sumberPghs,$tglPghs,$nominalPghs))
    {
        $msg= "<div class='alert alert-info'><strong>Berhasil!</strong> Data penghasilan berhasil diperbaharui. <a href='view-penghasilan.php'>Lihat daftar penghasilan</a>!</div>";
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
    extract($penghasilan->getID($id));
}
?>

<?php include_once "views/header.php"; ?>


    <div class="container">
        <h1>Ubah Data Penghasilan</h1>
        <hr>
        <?php
        if (isset($msg)){
            echo $msg;
        }
        ?>



        <div class="col-md-6">
            <form class="form-horizontal" method="post">

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="tglPghs">Tanggal penghasilan</label>
                    <div class="col-sm-8 input-group">
                        <input class="form-control" id="datepicker" name="tglPghs" type="date" value="<?php echo $tglPghs?>" required>
                        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="sumberPghs">Sumber penghasilan</label>
                    <div class="col-sm-8 input-group">
                        <input class="form-control" name="sumberPghs" type="text" placeholder="Contoh: Gaji kantor" value="<?php echo $sumberPghs?>" required>
                        <span class="input-group-addon">
          <span class="glyphicon glyphicon-list"></span>
        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="nominalPghs">Nominal penghasilan</label>
                    <div class="col-sm-8 input-group">
                        <span class="input-group-addon">Rp</span>
                        <input class="form-control" name="nominalPghs" type="number"
                               placeholder="Contoh: 2500000" pattern="\d*" value="<?php echo $nominalPghs?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 input-group">
                        <button class="btn btn-primary" name="submit" type="submit">
                            <span class="glyphicon glyphicon-plus"></span> &nbsp; Simpan
                        </button>
                        <!--                        <input type="submit" class="btn btn-primary" name="submit" value="Simpan">--> &nbsp;
                        <a href="view-penghasilan.php" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Kembali ke daftar penghasilan.</a>
                    </div>
                </div>

            </form>
        </div>


    </div>

<?php include_once 'views/footer.php'; ?>