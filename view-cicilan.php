<?php include_once 'views/header.php'; ?>
<?php
	include_once 'classes/class.crud.cicilan.php';
	$crud = new crud();

	if(isset($_GET['kom_id']) == "")
	{
	    exit("Page not Found");
	}
	elseif(empty($_GET['kom_id'])) 
	{ 
	  exit("Page not Found");
	}
	elseif(isset($_GET['kom_id']))
	{
	    $id = $_GET['kom_id'];
	    extract($crud->getID_komp($id)); 
	    if ($namaKomp === NULL)
	    {
	        exit("Page not Found");
	    } 
	    elseif ($userId != $userRow['userId'])
	    {
	        exit("Page not Found");
	    }
	}
?>



<div class="container">
	<h2><?php echo $namaKomp ?></h2>
	<a href="add-cicilan.php?kom_id=<?php echo $kompId ?>" class="btn btn-large btn-success"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
</div>

<div class="clearfix"></div><br />

<div class="container">
	<table class='table table-bordered table-responsive'>
	     <tr>
	     <th class="col-sm-1">#</th>
	     <th class="col-sm-3">Nama Cicilan</th>
	     <th class="col-sm-2">Tanggal Mulai</th>
	     <th class="col-sm-2">Tanggal Selesai</th>
	     <th class="col-sm-2">Jumlah</th>
	     <th colspan="2" align="center" class="col-sm-1">Actions</th>
	     </tr>
		    <?php
			  $query = " ";       
			  $crud->dataview($kompId,$userRow['userId']);
			?>
	 
	</table>  
       
</div>

<?php include_once 'views/footer.php'; ?>