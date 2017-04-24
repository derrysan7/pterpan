<?php include_once 'views/header_admin.php'; ?>
<?php

if(isset($_POST['btn-notif-cicilan']))
{
	$stmt = $auth_user->runQuery("SELECT userEmail, fullname, namaCicilan, tglCicilan, jmlCicilan 
									FROM users, cicilan, detailcicilan
									WHERE users.userId = cicilan.userId AND cicilan.cicilanId = detailcicilan.cicilanId 
										AND detailcicilan.tglCicilan = CURDATE() + INTERVAL 2 DAY");
	$stmt->execute();
	
	try
	{
		while ($userRow2=$stmt->fetch(PDO::FETCH_ASSOC)){
		$umail2 = $userRow2['userEmail'];
		$ufullname2 = $userRow2['fullname'];
		$unamaCicilan = $userRow2['namaCicilan'];
		$utglCicilan = date("d/m/Y", strtotime($userRow2['tglCicilan']));
		$ujmlCicilan = "Rp ". number_format($userRow2['jmlCicilan'],2,',','.');

		$message2 = "          
          Bapak/Ibu $ufullname2,
          <br /><br />
          Anda memiliki cicilan $unamaCicilan yang jatuh pada tanggal $utglCicilan sebesar $ujmlCicilan <br/> <br/>
          Terima Kasih";
          
	    $subject2 = "Cicilan $unamaCicilan";
	          
	    $auth_user->send_mail($umail2,$message2,$subject2); 
		}

		$msg = "<div class='alert alert-info'>
		      Pengiriman Notifikasi Cicilan Berhasil!
		      </div>";
	}
	catch(PDOException $e)
    {
        echo $e->getMessage();
    }
	
    
}

?>
<div class="clearfix"></div><br />

<div class="container">
	<?php
	if(isset($msg))
	{
	 echo $msg;
	}
	?>
	<h2>Notifikasi</h2>
	<form method='post'>
	    <table class='table table-bordered table-responsive'>

		     <tr>
		     <th><h4>Cicilan </h4></th>
		     <th align="right"><button type="submit" class="btn btn-primary" name="btn-notif-cicilan">Send</button> </th>
		     </tr>
		 
		</table>  
	</form>      
</div>