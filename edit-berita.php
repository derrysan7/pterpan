<?php include_once 'views/header_admin.php'; ?>
<?php
include_once 'classes/class.crud.berita.php';
$crud = new crud();

if(isset($_POST['btn-update']))
{
    $id = $_GET['edit_id'];
    extract($crud->getID($id));
    if ($userRow['userId'] == $userId){

            $bjudul = htmlspecialchars($_POST['txt_judul']);
            $bdeskripsi = $_POST['txt_deskripsi'];
            $bnamapen = $_POST['txt_namapen'];
            $imgFile = $_FILES['user_image']['name'];
            $tmp_dir = $_FILES['user_image']['tmp_name'];
            $imgSize = $_FILES['user_image']['size'];

            if($imgFile)
            {
                $upload_dir = 'user_images_berita/'; // upload directory   
                $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
                $userpic = uniqid('', true).".".$imgExt;
                if(in_array($imgExt, $valid_extensions))
                {           
                    if($imgSize < 2000000)
                    {
                        if ($gambar != 'placeholder.png'){
                        unlink($upload_dir.$gambar);
                        }
                        move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                    }
                    else
                    {
                        $errMSG = "Sorry, your file is too large it should be less then 2MB";
                    }
                }
                else
                {
                    $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
                }   
            }
            else
            {
                // if no image selected the old image remain as it is.
                $userpic = $gambar; // old image from database
            }    

         
            if(!isset($errMSG))
            {
                 if($crud->update($id,$bjudul,$bdeskripsi,$userpic,$bnamapen))
                 {
                  $msg = "<div class='alert alert-info'>
                    <strong>Success!</strong> Record was updated successfully <a href='berita.php'>HOME</a>!
                    </div>";
                 }
                 else
                 {
                  $msg = "<div class='alert alert-warning'>
                    <strong>Failed!</strong> ERROR while updating record !
                    </div>";
                 }
            }

    }else {
        exit("Edit Error! Wrong Author");
    }
}

if(isset($_GET['edit_id']))
{
	$id = $_GET['edit_id'];
	extract($crud->getID($id)); 
}

?>

<div class="clearfix"></div>

<div class="container">

    <?php
    	if(isset($msg))
    	{
    	 echo $msg;
    	}
    ?>

</div>

<div class="clearfix"></div><br />

<div class="container">

    <?php
    if(isset($errMSG)){
        ?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
    }
    ?>
  
     <form method="post" enctype="multipart/form-data"> 

            <div class="col-xs-8">
                <label>Gambar (JPEG, JPG, PNG, GIF)</label>
                <p><img src="user_images_berita/<?php echo $gambar; ?>" height="150" width="150" /></p>          
                <input class="input-group" type="file" name="user_image" accept="image/*" />
            </div>

            <div class="col-xs-8">
                <label>Judul</label>          
                <input type='text' name='txt_judul' class='form-control' value="<?php echo $judul ?>" maxlength="80" required>
            </div>

            <div class="col-md-8">
            <label>Deskripsi</label>
            <textarea class="form-control" rows="40"  wrap="hard" cols="80" name="txt_deskripsi" id="deskripsi" name="txt_deskripsi" required><?php echo $deskripsi ?></textarea>
            </div>
            

            <div class="col-xs-8" style="display: none;">
                <br>
                <input type='hidden' name='txt_namapen' class='form-control' value="<?php echo $namapen ?>" readonly>
            </div>
            <br>
            <div class="col-xs-8">
                <button type="submit" class="btn btn-primary" name="btn-update">
                <span class="glyphicon glyphicon-edit"></span>  Update this Record
                </button>
                <a href="berita.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; CANCEL</a>
            </div>
 
    </form>    
     
</div>

<?php include_once 'footer.php'; ?>