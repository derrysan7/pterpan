<?php 
require_once 'classes/class.crud.cicilan.php';
$page=3;
include_once 'views/header.php';
$crud = new crud();
$notfound="<div class='alert alert-danger'><span>Page not found!</span></div>";

if(isset($_POST['btn-del']))
{
  if ($userRow['userId'] == $userId)
  {
	 $id_del = $_GET['delete_id'];
	 extract($crud->getID_return($id_del));
	 $crud->delete_detail($id_del);
	 $crud->delete($id_del);
	 header("Location: delete-cicilan.php?deleted&return_id=".$kompId); 
  }
  else 
  {
	exit("Delete Error! Wrong Author");
  }
}
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="clearfix"></div>

	<div class="container">
		<?php
			if(isset($_GET['deleted']))
			{
				if(isset($_GET['return_id']) == "")
				{
				    exit($notfound);
				}
				elseif(empty($_GET['return_id'])) 
				{ 
				  exit($notfound);
				}
				elseif(isset($_GET['return_id']))
				{
				    $id = $_GET['return_id'];
				    extract($crud->getID_komp($id)); 
				    if ($namaKomp === NULL)
				    {
				        exit($notfound);
				    } 
				    elseif ($userId != $userRow['userId'])
				    {
				        exit($notfound);
				    }
				}
		?>
		    <div class="alert alert-success">
		     	<strong>Success!</strong> record was deleted... 
		  	</div>
		<?php
			}
			elseif(isset($_GET['delete_id']) && !empty($_GET['delete_id']))
			{
				$id = $_GET['delete_id'];
	    		extract($crud->getID($id));
	    		if ($userId != $userRow['userId'] OR $namaCicilan === NULL OR isset($_GET['delete_id']) == "")
			    {
			        exit($notfound);
			    }
		?>
		    <div class="alert alert-danger">
		     	<strong>Warning !</strong> remove the following record ? 
		  	</div>
		<?php
			}
			else
			{
				exit($notfound);
			}
		?> 
	</div>

	<div class="clearfix"></div>

	<div class="container">
	  
	<?php
		if(isset($_GET['delete_id']))
		{
	?>
	     <table class='table table-bordered'>
	         <tr>
	           <th class="col-sm-1">#</th>
	           <th class="col-sm-2">Nama Cicilan</th>
	           <th class="col-sm-3">Tanggal Mulai</th>
	           <th class="col-sm-2">Tanggal Berakhir</th>
	           <th class="col-sm-2">Jumlah</th>
	         </tr>
	         <tr>
	            <td><?php echo $id ?></td>
	            <td><?php echo $namaCicilan ?></td>
	            <td><?php echo $tglMulai ?></td>
	            <td><?php echo $tglSelesai ?></td>
	            <td><?php echo $jmlCicilan ?></td>
	         </tr>
	     </table>
	<?php
		}
	?>
	</div>

	<div class="container">
		<p>
			<?php
				if(isset($_GET['delete_id']))
				{
			?>
			   	<form method="post">
			    <input type="hidden" name="id" value="<?php echo $id ?>" />
			    <button class="btn btn-large btn-primary" type="submit" name="btn-del"><i class="glyphicon glyphicon-trash"></i> &nbsp; YES</button>
			    <a href="view-cicilan.php?kom_id=<?php echo $kompId ?>" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; NO</a>
			    </form>  
			<?php
				}
				else
				{
		 	?>
				    <a href="view-cicilan.php?kom_id=<?php echo $kompId ?>" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
		    <?php
				}
			?>
		</p>
	</div> 
</div>
<?php include_once 'footer.php'; ?>