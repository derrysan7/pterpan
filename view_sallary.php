<?php
require_once "core/init.php";



require_once "views/header.php";

?>

<div class="col-md-3"></div>

<div class="col-md-6">

  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nama Penghasilan</th>
        <th>Tanggal Penghasilan</th>
      </tr>
    </thead>
    <tbody>
      <?php get_sallary() ?>
    </tbody>
  </table>

</div>

<div class="col-md-3"></div>



<?php
require_once "views/footer.php";
?>
