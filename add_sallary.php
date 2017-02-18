<?php
require_once "core/init.php";

if ( isset($_POST['submit']) ) {
  $tanggal_penghasilan = trim($_POST['tanggal_penghasilan']);
  $nominal_penghasilan = trim($_POST['nominal_penghasilan']);
  $nama_penghasilan    = strip_tags(trim($_POST['nama_penghasilan']));

  if ( !empty($nama_penghasilan) && !empty($nominal_penghasilan) && validateDate($tanggal_penghasilan) &&
  filter_var($nominal_penghasilan,FILTER_VALIDATE_INT) && !empty($tanggal_penghasilan) ) {
    if ( insert_sallary($nama_penghasilan, $tanggal_penghasilan, $nominal_penghasilan) ) {
      // header('Location: sallary.php');
      $result = "<div class= 'alert alert-success'>Daftar penghasilan berhasil ditambahkan!</div>";
    }else {
      die("Gagal");
    }
  }else {
    // echo "Masukkan data dengan lengkap!";
    $result = "<div class= 'alert alert-danger'>Masukkan data dengan lengkap!</div>";

  }
}

require_once "views/header.php";

?>


<div class="col-md-3">
</div>

<div class="col-md-6">
  <form class="form-horizontal" action="add_sallary.php" method="post">

    <div class="form-group">
      <label class="col-sm-4 control-label" for="tanggal_penghasilan">Tanggal penghasilan</label>
      <div class="col-sm-8 input-group">
        <input class="form-control" id="datepicker" name="tanggal_penghasilan" type="text">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>

    </div>

    <div class="form-group">
      <label class="col-sm-4 control-label" for="nama_penghasilan">Nama penghasilan</label>
      <div class="col-sm-8 input-group">
        <input class="form-control" name="nama_penghasilan" type="text" placeholder="Contoh: Gaji kantor">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-list"></span>
        </span>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4 control-label" for="nominal_penghasilan">Nominal penghasilan</label>
      <div class="col-sm-8 input-group">
        <span class="input-group-addon">Rp</span>
        <input class="form-control" name="nominal_penghasilan" type="text"
        placeholder="Contoh: 2500000" pattern="\d*">
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-4"></div>
      <div class="col-md-8 input-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Simpan"><br><br>
        <?php echo $result; ?>
      </div>
    </div>

  </form>
</div>

<div class="col-md-3">
</div>

<?php
require_once "views/footer.php";
?>
