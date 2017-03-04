<?php

require_once('dbconfig.php');

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
}
?>