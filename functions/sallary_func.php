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

  function get_sallary(){
    global $db_connect;

    $query = "SELECT * FROM penghasilan GROUP BY tanggal_penghasilan ORDER BY tanggal_penghasilan DESC";

    if ( $result = mysqli_query($db_connect,$query) ) {

      if ( mysqli_num_rows($result) > 0 ) {

        while ( $data = mysqli_fetch_assoc($result) ) {
          echo
          "<tr>
            <td>".$data['nama_penghasilan']."</td>
            <td>".$data['tanggal_penghasilan']."</td>
          </tr>
          ";
        }
      }else {
        return false;
      }
    }

  }

  ?>
