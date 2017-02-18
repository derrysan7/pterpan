<?php
require_once "views/header.php";
require_once "core/init.php";
?>


<div class="col-md-3">
</div>

<div class="col-md-6">
  <form class="form-horizontal" action="sallary.php" method="post">

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
        <input type="submit" class="btn btn-primary" name="submit" value="Simpan">

      </div>
    </div>

  </form>
</div>

<div class="col-md-3">
</div>

<?php
require_once "views/footer.php";
?>
