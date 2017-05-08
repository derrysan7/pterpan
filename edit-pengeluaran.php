<?php
require_once "classes/class.crud.pengeluaran.php";
include_once "views/header.php";
$pengeluaran = new Pengeluaran();



if(isset($_POST['submit']))
{
    $tgl = explode("/",$_POST['tglKomp']);
    $tglFormat = $tgl[0]."/01/".$tgl[1];
    $tglFormat=date('Y-m-d',strtotime($tglFormat));
    $tipePngl = isset($_POST['tipePngl']);
    $tglKomp = $tglFormat;
    $kompId = $_GET['edit_id'];
    $namaKomp = $_POST['namaKomp'];
    $persenKomp = $_POST['persenKomp'];
    $tglKomp = $tglFormat;


    if($pengeluaran->update($userRow['userId'],$kompId,$namaKomp,$tipePngl,$tglKomp,$persenKomp))
    {
        $msg= "<div class='alert alert-info'><strong>Berhasil!</strong> Data pengeluaran berhasil diperbaharui. <a href='view-pengeluaran.php'>Lihat daftar pengeluaran</a>!</div>";
    }
    else
    {
        $msg="<div class='alert alert-warning'>
            <strong>Maaf</strong>, data Anda tidak dapat diperbarui karena persentase komponen yang Anda masukkan 
            menyebabkan total persentase pengeluaran Anda menjadi > 100%.
        </div>";
    }
}

if(empty($_GET['edit_id'])){
    exit("Page not found!");
}elseif (isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    extract($pengeluaran->getID($id));
    if($namaKomp===null){
        exit("Page not found!");
    }elseif ($userId != $userRow['userId']){
        exit("Page not found!");
    }
}

//if(isset($_GET['edit_id']))
//{
//    $id = $_GET['edit_id'];
//    extract($pengeluaran->getID($id));
//}

if ($tipePngl=="cicilan"){
    $tipe="checked";
}else{
    $tipe="";
}
?>




    <div class="container">
        <h1>Ubah Data Komponen Pengeluaran</h1>
        <hr>
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
                            <input class="form-control" name="namaKomp" type="text" value="<?php echo $namaKomp ?>" placeholder="Contoh: Transportasi" maxlength="15" required>
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
                    <?php
                    $tglKomp=explode("-",$tglKomp);
                    $tglKomp = $tglKomp[1]."/".$tglKomp[0];
                    ?>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="tglKomp">Periode</label>
                        <div class="col-sm-8 input-group">
                            <input class="form-control date-picker" name="tglKomp" value="<?php echo $tglKomp?>" readonly required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-sm-8 input-group checkbox">
                            <label><input name="tipePngl" type="checkbox" value=true <?php echo $tipe?> >
                                Cicilan</label>
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