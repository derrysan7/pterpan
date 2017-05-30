<?php
session_start();
require_once("classes/class.user.php");
$login = new USER();
$date_index_login = date("m-Y");
if($login->is_loggedin()!="")
{
	// $login->redirect("index.php?selected_month=".$date_index_login);
    $login->redirect("indexadmin.php");
}

if(isset($_POST['btn-login']))
{
	$uname = strip_tags($_POST['txt_uname_email']);
	$umail = strip_tags($_POST['txt_uname_email']);
	$upass = strip_tags($_POST['txt_password']);
		
	if($login->doLogin($uname,$umail,$upass))
	{
		$login->redirect('indexadmin.php');
	}
	else
	{
		$error = "Wrong Details !";
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Piggybank : Login</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
<link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="style/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style/css/style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading">Log In to Piggybank</h2><hr />
        <?php
            if(isset($_GET['inactive']))
            {
                $error = "Akun Belum diaktifkan";
            }
        ?>
        
        <div id="error">
        <?php

		if(isset($error))
		{
			?>
            <div class="alert alert-danger">
               <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
            </div>
            <?php
		}
		?>
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID" required />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" name="txt_password" placeholder="Your Password" />
        </div>
       
     	<hr />
        
        <div class="form-group">
            <button type="submit" name="btn-login" class="btn btn-default">
                	<i class="glyphicon glyphicon-log-in"></i> &nbsp; SIGN IN
            </button>
        </div>
        <a href="fpass.php">Lupa Password ? </a>  
      	<br />
        <br/>
            <label>Belum Punya Akun? <a href="register.php">Register</a></label> <br>
      </form>

    </div>
    
</div>

</body>
</html>