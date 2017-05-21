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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="style/bootstrap/js/jquery-1.11.3-jquery.min.js"></script>
    <script src="style/bootstrap/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="style/css/jquery-ui.css"> -->
    <script src="style/js/jquery-1.12.4.js"></script>
    <script src="style/js/jquery-ui.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="js/lumino.glyphs.js"></script>
    <script>
    $( function() {
      $( "#datepicker" ).datepicker();
    } );
    $( function() {
      $( "#datepicker2" ).datepicker();
    } );
    </script>

    <script src="js/highcharts.js"></script>

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
    <link rel="stylesheet" href="style/css/style.css" type="text/css"  />
    <title>Peterpan</title>
</head>

<body>
<?php $date_header_dashboard = date("m-Y");?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php?selected_month=<?php echo $date_header_dashboard ?>"><span>Keuangan</span>Pterpan</a>
        <ul class="user-menu">
          <li class="dropdown pull-right">
            <a href="#" class="dropdown-toggle" style="display:<?php echo $userinfo ?>;" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $userRow['userEmail']; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
<!--              <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
              <li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li> -->
              <li><a href="logout.php?logout=true" style="display:<?php echo $userinfo ?>;">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
              
    </div><!-- /.container-fluid -->
  </nav>
  <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <ul class="nav menu">
      <li class="active"><a href="index.php?selected_month=<?php echo $date_header_dashboard ?>">Dashboard</a></li>
      <li><a href="view-penghasilan.php">Penghasilan</a></li>
      <li><a href="">Pengeluaran</a></li>
    </ul>
  </div><!--/.sidebar-->


