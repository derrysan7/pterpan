<?php

function insert_sallary($nama_penghasilan, $tanggal_penghasilan, $nominal_penghasilan){
  global $db_connect;

  //sanitasi sql injection
  $nama_penghasilan  = mysqli_real_escape_string($db_connect,$nama_penghasilan);
  $tanggal_penghasilan  = mysqli_real_escape_string($db_connect,$tanggal_penghasilan);
  $nominal_penghasilan  = mysqli_real_escape_string($db_connect,$nominal_penghasilan);

  $query = "INSERT INTO penghasilan(id_user,nama_penghasilan,tanggal_penghasilan,
  nominal_penghasilan) VALUES(1,'$nama_penghasilan','$tanggal_penghasilan','$nominal_penghasilan')";

  if ( mysqli_query($db_connect,$query) ) {
    return true;
  }else {
    return false;
  }

}

 ?>
