<?php
  require_once ("session.php");
	require_once ("classes/class.user.php");
	$auth_user = new USER();
  //error_reporting(0);

  if ($_SESSION['user_session']!=""){
      $userId = $_SESSION['user_session'];
      
      $stmt = $auth_user->runQuery("SELECT * FROM users WHERE userId=:userId");
      $stmt->execute(array(":userId"=>$userId));
      
      $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
      $userinfo="yes";
      $signinbutton="none";
      } 
      else
      {
      $userinfo="none";
      $signinbutton="yes";
      }




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="style/bootstrap/js/jquery-1.11.3-jquery.min.js"></script>
    <link href="style/css/font-face.css" rel="stylesheet" type="text/css">
    
    <script src="js/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea', 
                            plugins: "table advlist link image",
                              setup: function (editor) {
                              editor.on('change', function () {
                              editor.save();
                                    });
                              }

                          });</script>
    <link rel="stylesheet" href="style/css/style.css" type="text/css"  />
    <title>Peterpan</title>
</head>

<body>

<nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Program Peterpan</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">

            <li><a href="index.php">Beranda</a></li>
            <li><a href="view-penghasilan.php">Penghasilan</a></li>
            <li><a href="">Pengeluaran</a></li>
            <li><a href="">Cicilan</a></li>
            <li><a href="">Laporan</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
              
                <li><a href="" style="display:<?php echo $userinfo ?>;"><span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userEmail']; ?></a></li>
                <li><a href="logout.php?logout=true" style="display:<?php echo $userinfo ?>;"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                <li><a href="login.php" style="display:<?php echo $signinbutton ?>;"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Sign In</a></li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

