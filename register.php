<?php
session_start();
include_once 'dbconfig.php';
require_once('classes/class.user.php');
$user = new USER();

if($user->is_loggedin()!="")
{
  $user->redirect('index.php');
}

if(isset($_POST['btn-save']))
{
    $uname = strip_tags($_POST['txt_uname']);
    $umail = strip_tags($_POST['txt_umail']);
    $upass = strip_tags($_POST['txt_upass']);
    $ufullname = htmlspecialchars($_POST['txt_ufullname']);
    $ualamat = htmlspecialchars($_POST['txt_ualamat']);
    $usumber_peng = htmlspecialchars($_POST['txt_usumber_peng']);
    $unohp = htmlspecialchars($_POST['txt_unohp']);
    $unpwp = htmlspecialchars($_POST['txt_unpwp']);
    $uktp = htmlspecialchars($_POST['txt_uktp']);
    $ustatus = htmlspecialchars($_POST['drop_ustatus']);
    $ujumlah_tang = htmlspecialchars($_POST['txt_ujumlah_tang']);
    $code = bin2hex(openssl_random_pseudo_bytes(16));

    if(strlen(trim($uname)) == 0)  {
        $error[] = "provide username !";    
    }
    else if($umail=="") {
        $error[] = "provide email id !";    
    }
    else if(!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Please enter a valid email address !';
    }
    else if($upass=="") {
        $error[] = "provide password !";
    }
    else if(strlen($upass) < 8){
        $error[] = "Password must be atleast 8 characters"; 
    }
    else if(strlen(trim($ufullname)) == 0) {
        $error[] = "provide fullname !";    
    }
    else
    {
        try
        {
            $stmt = $user->runQuery("SELECT userName, userEmail FROM users WHERE userName=:uname OR userEmail=:umail");
            $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
                
            if($row['userName']==$uname) {
                $error[] = "sorry username already taken !";
            }
            else if($row['userEmail']==$umail) {
                $error[] = "sorry email id already taken !";
            }
            else
            {
                if($user->register($uname,$umail,$upass,$ufullname,$ualamat,$usumber_peng,$unohp,$unpwp,$uktp,$ustatus,$ujumlah_tang,$code))
                 {                   
                    header("Location: register.php?inserted");
                 }
                 else
                 {
                    header("Location: register.php?failure");
                 }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }   
}
?>

<div class="clearfix"></div>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Peterpan : Register</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
<link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="style/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style/css/style.css" type="text/css"  />
<script>
  function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
  }

  function isNumberKey2(evt){
      var charCode = (evt.which) ? evt.which : event.Keycode
      if (charCode == 32)
        return false;
      return true;
  }

</script>
</head>
<body>

<div class="signin-form">

  <div class="container">
       
          
    <form class="form-signin" method="post" id="login-form">
        
      <h2 class="form-signin-heading">Register Peterpan</h2><hr />
          <?php
            if(isset($error))
            {
                foreach($error as $error)
                {
                     ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
                }
            }
            else if(isset($_GET['inserted']))
            {
                 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Berhasil Register! Anda akan Menerima Email Konfirmasi dari Admin Paling Lama 48 jam.
                 </div>
                 <?php
            }
            ?>
          
          <div class="form-group">
            <h5>Username</h5>
            <input type='text' name='txt_uname' onkeypress="return isNumberKey2(event)" class='form-control' value="<?php if(isset($error)){echo $uname;}?>" maxlength="30" required>
          </div>
          
          <div class="form-group">
            <h5>Email</h5>
            <input type='text' name='txt_umail' onkeypress="return isNumberKey2(event)" class='form-control' value="<?php if(isset($error)){echo $umail;}?>" maxlength="60" required>
          </div>

          <div class="form-group">
          <h5>Password</h5>
            <input type='password' name='txt_upass' onkeypress="return isNumberKey2(event)" class='form-control' required>
          </div>

          <div class="form-group">
            <h5>Nama Lengkap</h5>
            <input type='text' name='txt_ufullname' class='form-control' maxlength="50" value="<?php if(isset($error)){echo $ufullname;}?>" required>
          </div>

          <div class="form-group">
            <h5>Alamat</h5>
            <input type='text' name='txt_ualamat' class='form-control' maxlength="200" value="<?php if(isset($error)){echo $ualamat;}?>" required>
          </div>

          <div class="form-group">
            <h5>Sumber Penghasilan (Bekerja, Orang Tua, Saudara)</h5>           
            <input type='text' name='txt_usumber_peng' class='form-control' maxlength="50" value="<?php if(isset($error)){echo $usumber_peng;}?>" required>
          </div>

          <div class="form-group">
            <h5>No. Handphone</h5>
            <input type='number' onkeypress="return isNumberKey(event)" name='txt_unohp' class='form-control' min="0" max="99999999999999999999" value="<?php if(isset($error)){echo $unohp;}?>" required>
          </div>

          <div class="form-group">
            <h5>No. NPWP</h5>
            <input type='number' onkeypress="return isNumberKey(event)" name='txt_unpwp' class='form-control' min="0" max="999999999999999" value="<?php if(isset($error)){echo $unpwp;}?>" required>
          </div>

          <div class="form-group">
            <h5>No. KTP</h5>
            <input type='number' onkeypress="return isNumberKey(event)" name='txt_uktp' class='form-control' min="0" max="99999999999999999" value="<?php if(isset($error)){echo $uktp;}?>" required>
          </div>

          <div class="form-group">
            <h5>Status</h5>
            <select class="form-control" name="drop_ustatus" required>
              <option selected disabled>Status Pernikahan</option>
              <option>Menikah</option>
              <option>Tidak Menikah</option>
            </select>
          </div>

          <div class="form-group">
            <h5>Jumlah Tanggungan</h5>
            <input type='number' onkeypress="return isNumberKey(event)" name='txt_ujumlah_tang' class='form-control' min="0" max="99" value="<?php if(isset($error)){echo $ujumlah_tang;}?>" required>
          </div>
         
        <hr />
          
          <div class="form-group">
              <button type="submit" class="btn btn-primary" name="btn-save">
                Register
             </button>  
          </div>
          <a href="fpass.php">Lupa Password ? </a>  
          <br />
          <br/>

              <label>Sudah Punya Akun? <a href="login.php">Login</a></label> <br>
              <label><a href="index.php">Kembali ke Beranda</a></label>
    </form>

  </div>
    
</div>

</body>
</html>