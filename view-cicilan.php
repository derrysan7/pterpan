<?php $page=3; include_once 'views/header.php'; ?>
<?php
	include_once 'classes/class.crud.cicilan.php';
	$crud = new crud();
	include_once "classes/class.crud.pengeluaran.php";
	$pengeluaran = new Pengeluaran();

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


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main"> 

	<div class="clearfix"></div>

    <div class="container">
        <h1>Anggaran <?php echo ucwords($namaKomp); ?></h1>
        <hr>
        <h6>Summary :</h6>
        <div class="col-md-6">
            <table class='table  table-responsive '>
                <tr>
                    <td class="col-md-2">Nama Komponen Anggaran</td>

                    <td class="col-md-4">: &nbsp;<?php echo ucwords($namaKomp); ?></td>
                </tr>
                <tr>
                    <td class="col-md-2">Nominal Anggaran</td>

                    <td class="col-md-4">: &nbsp;<?php print 'Rp &nbsp;'.number_format($anggaranPngl,2,',','.'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="view-pengeluaran.php" class="btn btn-info btn-xs">Daftar Komponen Pengeluaran</a>
                        <a href="edit-ang-cicilan.php?pngl_id=<?php print($pengeluaranId); ?>" class="btn btn-warning btn-xs">Ubah</a>&nbsp;
                    </td>
                </tr>
            </table>
        </div>

    </div>

	<div class="container">
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
</div>
<?php include_once 'views/footer.php'; ?>