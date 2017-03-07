<?php

require_once $_SERVER['DOCUMENT_ROOT']."/pterpan/routes/dbconfig.php";

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function lastID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}

	public function antiforgerytoken()
	{
		if (!isset($_SESSION['token'])) {
		    $token = bin2hex(openssl_random_pseudo_bytes(16));
		    $_SESSION['token'] = $token;
		}
		else
		{
		    $token = $_SESSION['token'];
		}
	}
	
	public function register($uname,$umail,$upass,$ufullname,$ualamat,$usumber_peng,$unohp,$unpwp,$uktp,$ustatus,$ujumlah_tang,$code)
	{
		try
		  {
		    $new_password = password_hash($upass, PASSWORD_DEFAULT);

		    if($ustatus == "Menikah") {
		         $ustatus2 = "1";
		         }
		         else{
		         $ustatus2 = "2";
		       }

		   $stmt = $this->conn->prepare("INSERT INTO users(userName,userEmail,userPass,fullname,alamat,sumber_peng,no_hp,npwp,ktp,status,jumlah_tang,tokenCode) 
		                                                   VALUES(:uname, :umail, :upass, :ufullname, :ualamat, :usumber_peng, :unohp, :unpwp, :uktp, :ustatus, :ujumlah_tang, :active_code)");
		   $stmt->bindparam(":uname", $uname);
		   $stmt->bindparam(":umail", $umail);
		   $stmt->bindparam(":upass", $new_password);
		   $stmt->bindparam(":ufullname", $ufullname);
		   $stmt->bindparam(":ualamat", $ualamat);
		   $stmt->bindparam(":usumber_peng", $usumber_peng);
		   $stmt->bindparam(":unohp", $unohp);
		   $stmt->bindparam(":unpwp", $unpwp);
		   $stmt->bindparam(":uktp", $uktp);
		   $stmt->bindparam(":ustatus", $ustatus2);
		   $stmt->bindparam(":ujumlah_tang", $ujumlah_tang);
		   $stmt->bindparam(":active_code",$code);
		   $stmt->execute();
		   return true;
		  }
		  catch(PDOException $e)
		  {
		   echo $e->getMessage(); 
		   return false;
		  }				
	}
	
	
	public function doLogin($uname,$umail,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE userName=:uname OR userEmail=:umail ");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if($userRow['verifikasiUser']=="Y")
				{
					if(password_verify($upass, $userRow['userPass']))
					{
						$_SESSION['user_session'] = $userRow['userId'];
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					header("Location: login.php?inactive");
					exit;
				}	
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}

	public function crudLabel($permission)
	{
		if ($permission == 1)
		{
			$label = "CRUD User";
		}
		else
		{
			$label = "CRUD Content";
		}
		return $label;

	}

	public function crudLink($permission){
		if ($permission == 1)
		{
			$link = "listuser.php";
		}
		else
		{
			$link = "crud_berita_utama.php";
		}
		return $link;
	}

	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
    $mail->IsSMTP(); 
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host       = "smtp.gmail.com";
    $mail->Port       = 465; 
    $mail->AddAddress($email);
    $mail->Username="cobahmsi@gmail.com";
    $mail->Password="rpl1uyee";
    $mail->SetFrom('cobahmsi@gmail.com','Admin Peterpan');
    $mail->AddReplyTo("cobahmsi@gmail.com","Admin Peterpan");
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    $mail->Send();
	}

	public function dataview($query)
	 {
	  $stmt = $this->conn->prepare($query);
	  $stmt->execute();
	 
	  if($stmt->rowCount()>0)
	  {
	   while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		   {
				if($row['verifikasiAdmin'] == "N"){
					$buttonstatus = "";
					$buttontext = "Verify";
				} else {
					$buttonstatus = "disabled";
					$buttontext = "Verified";
				}

				    ?>
		                <tr>
		                <td><?php print($row['userId']); ?></td>
		                <td><?php print($row['userName']); ?></td>
		                <td><?php print($row['userEmail']); ?></td>
		                <td><?php print($row['fullname']); ?></td>
		                <td><?php print($row['NamaPermission']); ?></td>
		                <td><?php print($row['alamat']); ?></td>
		                <td><?php print($row['sumber_peng']); ?></td>
		                <td><?php print($row['no_hp']); ?></td>
		                <td><?php print($row['npwp']); ?></td>
		                <td><?php print($row['ktp']); ?></td>
		                <td><?php print($row['status']); ?></td>
		                <td><?php print($row['jumlah_tang']); ?></td>
		                <td align="center">
		                <!--<a href="?user_id=<?php print($row['userId']); ?>" type="submit" class="btn btn-primary btn-block <?php echo $buttonstatus; ?>" name="btn-verify" role="button"><?php echo $buttontext; ?></a>-->
		                <button type="submit" class="btn btn-primary btn-block <?php echo $buttonstatus; ?>" value="<?php echo $row['userId']; ?>" name="btn-verify"><?php echo $buttontext; ?></button>
		                </td>
		                </tr>
	                <?php
		   }
	  }
	  else
		  {
		   ?>
	            <tr>
	            <td>Nothing here...</td>
	            </tr>
	        <?php
		  }
	  
	 }

	 public function paging($query,$records_per_page)
	 {
		  $starting_position=0;
		  if(isset($_GET["page_no"]))
		  {
		   	$starting_position=($_GET["page_no"]-1)*$records_per_page;
		  }
		  $query2=$query." limit $starting_position,$records_per_page";
		  return $query2;
	 }
	 
	 public function paginglink($query,$records_per_page)
	 {
	  
	  $self = $_SERVER['PHP_SELF'];
	  
	  $stmt = $this->conn->prepare($query);
	  $stmt->execute();
	  
	  $total_no_of_records = $stmt->rowCount();
	  
	  if($total_no_of_records > 0)
	  	{
		   ?><ul class="pagination"><?php
		   $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
		   $current_page=1;
		   if(isset($_GET["page_no"]))
		   {
		    	$current_page=$_GET["page_no"];
		   }
		   if($current_page!=1)
		   {
			    $previous =$current_page-1;
			    echo "<li><a href='".$self."?page_no=1'>First</a></li>";
			    echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
		   }
		   for($i=1;$i<=$total_no_of_pages;$i++)
		   {
			    if($i==$current_page)
			    {
			     	echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
			    }
			    else
			    {
			     	echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
			    }
		   }
		   if($current_page!=$total_no_of_pages)
		   {
			    $next=$current_page+1;
			    echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
			    echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
		   }
		   ?></ul><?php
		}
	 }
}
?>