<?php
function validateDate($tanggal_penghasilan)
{
  $tanggal = (int)substr($tanggal_penghasilan,3,2);
  $bulan = (int)substr($tanggal_penghasilan,0,2);
  $tahun = (int)substr($tanggal_penghasilan,6,4);
  $tgl_len = strlen((string)$tanggal);
  $bln_len = strlen((string)$bulan);
  $th_len = strlen((string)$tahun);

if ( checkdate($bulan,$tanggal,$tahun) && ($tgl_len <= 2) && ($bln_len <= 2) && ($th_len == 4)) {
  return true;
}else {
  return false;
}

  
}
?>
