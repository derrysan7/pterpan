<?php $page=2; include_once 'views/header_admin.php'; ?>
<?php
include_once 'classes/class.crud.berita.php';
$crud = new crud();

if(isset($_GET['delete_id']))
{
	$id = $_GET['delete_id'];
	extract($crud->getID($id)); 
}

if(isset($_POST['btn-del']))
{
  if ($userRow['userId'] == $userId)
  {
	 $id_del = $_GET['delete_id'];
	 if ($gambar != 'placeholder.png')
	 {
	    unlink("user_images_berita/".$gambar);
	 } 
	 $crud->delete($id_del);
	 header("Location: delete-berita.php?deleted"); 
  }
  else 
  {
	exit("Delete Error! Wrong Author");
  }
}

?>

<div class="clearfix"></div>

<div class="container">
	<?php
		if(isset($_GET['deleted']))
		{
	?>
	    <div class="alert alert-success">
	     	<strong>Success!</strong> record was deleted... 
	  	</div>
	<?php
		}
		else
		{
	?>
	    <div class="alert alert-danger">
	     	<strong>Warning !</strong> remove the following record ? 
	  	</div>
	<?php
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
           <th class="col-sm-2">Tanggal Dibuat</th>
           <th class="col-sm-3">Judul</th>
           <th class="col-sm-2">Nama Penulis</th>
         </tr>
         <tr>
            <td><?php echo $id ?></td>
            <td><?php echo $tanggaldib ?></td>
            <td><?php echo $judul ?></td>
            <td><?php echo $namapen ?></td>
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
		    <a href="berita.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; NO</a>
		    </form>  
		<?php
			}
			else
			{
	 	?>
			    <a href="berita.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
	    <?php
			}
		?>
	</p>
</div> 
<?php include_once 'footer.php'; ?>