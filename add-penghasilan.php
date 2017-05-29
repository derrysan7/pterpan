<?php
require_once "classes/Penghasilan.php";
$page=2;
include_once "views/header.php";
$penghasilan = new Penghasilan();

if(isset($_POST['submit']))
{
    $userId = $userRow['userId'];
    $tglPghs = $_POST['tglPghs'];
    $sumberPghs = $_POST['sumberPghs'];
    $nominalPghs = $_POST['nominalPghs'];

    if($penghasilan->create($userId,$sumberPghs,$tglPghs,$nominalPghs))
    {
        header("Location: add-penghasilan.php?inserted");
    }
    else
    {
        header("Location: add-penghasilan.php?failure");
    }
}
?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="clearfix"></div>

        <?php
        if(isset($_GET['inserted']))
        {
            ?>
            <div class="container">
                <div class="alert alert-info">
                    <strong>Berhasil!</strong> Data penghasilan berhasil ditambahkan. <a href="view-penghasilan.php">Lihat daftar penghasilan</a>!
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
            <h1>Tambah Penghasilan</h1>
            <hr>

            <div class="col-md-6">
                <form class="form-horizontal" method="post">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="tglPghs">Tanggal penghasilan</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" type="date" name="tglPghs" required>
                            <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="sumberPghs">Sumber penghasilan</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" name="sumberPghs" type="text" placeholder="Contoh: Gaji kantor" required>
                            <span class="input-group-addon">
          <span class="glyphicon glyphicon-list"></span>
        </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="nominalPghs">Nominal penghasilan</label>
                        <div class="col-sm-8 input-group">
                            <span class="input-group-addon">Rp</span>
                            <input class="form-control" name="nominalPghs" onkeypress="return isNumberKey(event)"
                                   placeholder="Contoh: 2500000" pattern="\d*" required>
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
    </div>

<?php include_once 'views/footer.php'; ?>