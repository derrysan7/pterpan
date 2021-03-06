<?php
require_once "classes/class.crud.anggaran.php";
$page=3;
include_once "views/header.php";
$anggaran = new Anggaran();



if(isset($_POST['submit']))
{
    $tglPngl = $_POST['tglPngl'];
    $anggaranPngl = $_POST['anggaranPngl'];


    if($anggaran->create($id,$tglPngl,$anggaranPngl))
    {
        header("Location: add-anggaran.php?inserted");
    }
    else
    {
        header("Location: add-anggaran.php?failure");
    }
}

if(isset($_GET['kom_id']))
{
    $id = $_GET['kom_id'];
    extract($anggaran->getID($id));
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
                    <strong>Berhasil!</strong> Data anggaran berhasil diatur. <a href="view-pengeluaran.php">Lihat komponen pengeluaran</a>!
                </div>
            </div>
            <?php
        }
        else if(isset($_GET['failure']))
        {
            ?>
            <div class="container">
                <div class="alert alert-warning">
                    <strong>Maaf</strong>, terjadi kesalahan saat mengatur data.
                </div>
            </div>
            <?php
        }
        ?>

        <div class="clearfix"></div><br />

        <div class="container">
            <h1>Anggaran <?php echo ucwords($namaKomp); ?></h1>
            <hr>

            <div class="col-md-6">
                <form class="form-horizontal" method="post">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="tglPngl">Periode anggaran</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control" id="datepicker" name="tglPngl" type="date" required>
                            <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="anggaranPngl">Batas Anggaran</label>
                        <div class="col-sm-8 input-group">
                            <span class="input-group-addon">Rp</span>
                            <input class="form-control" name="anggaranPngl" type="number"
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
                            <a href="view-pengeluaran.php" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Komponen pengeluaran.</a>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

<?php include_once 'views/footer.php'; ?>