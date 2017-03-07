<?php include_once 'views/header_admin.php'; ?>
<?php
	include_once 'classes/class.crud.berita.php';
	$crud = new crud();
?>

<div class="container">
	<h2>Daftar Berita</h2>
	<a href="add-berita.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
</div>

<div class="clearfix"></div><br />

<div class="container">
	<table class='table table-bordered table-responsive'>
	     <tr>
	     <th class="col-sm-1">#</th>
	     <th class="col-sm-2">Tanggal Dibuat</th>
	     <th class="col-sm-5">Judul</th>
	     <th class="col-sm-2">Nama Penulis</th>
	     <th colspan="2" align="center" class="col-sm-1">Actions</th>
	     </tr>
		    <?php
			  $query = "SELECT * FROM berita WHERE userId='".$userRow['userId']."' ORDER BY tanggaldib DESC ";       
			  $records_per_page=5;
			  $newquery = $crud->paging($query,$records_per_page);
			  $crud->dataview($newquery);
			?>
	    <tr>
	        <td colspan="6" align="center">
		    	<div class="pagination-wrap">
		            <?php $crud->paginglink($query,$records_per_page); ?>
		        </div>
	        </td>
	    </tr>
	 
	</table>  
       
</div>

<?php include_once 'footer.php'; ?>

