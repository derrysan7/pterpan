<?php include_once 'views/header_admin.php'; ?>
<?php

if(isset($_POST['btn-verify']))
{
	//$userIdVerify = $_GET['user_id'];
	$userIdVerify = $_POST['btn-verify'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE userId=:userId");
	$stmt->execute(array(":userId"=>$userIdVerify));
	$userRow2=$stmt->fetch(PDO::FETCH_ASSOC);

	$statusY = "Y";
	$stmt = $auth_user->runQuery("UPDATE users SET verifikasiAdmin=:veradmin WHERE userId=:uID");
	$stmt->bindparam(":veradmin",$statusY);
	$stmt->bindparam(":uID",$userIdVerify);
	$stmt->execute();

	$uname2 = $userRow2['userName'];
    $umail2 = $userRow2['userEmail'];
    $code2 = bin2hex(openssl_random_pseudo_bytes(16));

    $stmt = $auth_user->runQuery("UPDATE users SET tokenCode=:token WHERE userEmail=:umail");
    $stmt->execute(array(":token"=>$code2,"umail"=>$umail2));

    $autoid2 = $userIdVerify;   
    $key2 = base64_encode($autoid2);
    $autoid2 = $key2;
    
    $message2 = "          
          Halo $uname2,
          <br /><br />
          Selamat datang di peterpan<br/>
          Untuk Menyelesaikan Registrasi, Silahkan Klik Link dibawah<br/>
          <br /><br />
          <a href='localhost/pterpan/verify.php?id=$autoid2&code=$code2'>Click DISINI untuk aktivasi</a>
          <br /><br />
          Terima Kasih,";
          
    $subject2 = "Confirm Registration";
          
    $auth_user->send_mail($umail2,$message2,$subject2); 

    $msg = "<div class='alert alert-info'>
      Verifikasi Email Berhasil!
      </div>";
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
	<h2>Daftar User</h2>
	<form method='post'>
	    <table class='table table-bordered table-responsive'>

		     <tr>
		     <th>#</th>
		     <th>Username</th>
		     <th>Email</th>
		     <th>Full Name</th>
		     <th>Permission</th>
		     <th>Alamat</th>
		     <th>Sumber Penghasilan</th>
		     <th>No.HP</th>
		     <th>NPWP</th>
		     <th>KTP</th>
		     <th>Status</th>
		     <th>Jumlah Tanggungan</th>
		     <th colspan="1" align="center">Actions</th>
		     </tr>
			     <?php
				  $query = "SELECT * FROM users";       
				  $records_per_page=5;
				  $newquery = $auth_user->paging($query,$records_per_page);
				  $auth_user->dataview($newquery);
				  ?>
		    <tr>
		        <td colspan="13" align="center">
		    	<div class="pagination-wrap">
		            <?php $auth_user->paginglink($query,$records_per_page); ?>
		         </div>
		        </td>
		    </tr>
		 
		</table>  
	</form>      
</div>