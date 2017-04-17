<?php include_once 'views/header.php'; ?>
<?php
	include_once 'classes/class.crud.cicilan.php';
	$crud = new crud();
?>

<div class="container">
	<h2>Daftar Cicilan</h2>
	<a href="add-cicilan.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
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
			  $query = "SELECT * FROM cicilan WHERE userId='".$userRow['userId']."' ORDER BY tglDibuat DESC ";       
			  $records_per_page=5;
			  $newquery = $crud->paging($query,$records_per_page);
			  $crud->dataview($newquery);
			?>
	    <tr>
	        <td colspan="7" align="center">
		    	<div class="pagination-wrap">
		            <?php $crud->paginglink($query,$records_per_page); ?>
		        </div>
	        </td>
	    </tr>
	 
	</table>  
       
</div>

<?php include_once 'views/footer.php'; ?>