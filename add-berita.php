<?php include_once 'views/header_admin.php'; ?>
<?php
include_once 'classes/class.crud.berita.php';
$crud = new crud();

if(isset($_POST['btn-save']))
{
    $buserid = $_POST['txt_userid'];
    $bjudul = htmlspecialchars($_POST['txt_judul']);
    $bdeskripsi = $_POST['txt_deskripsi'];
    $bnamapen = $_POST['txt_namapen'];

    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];

    if (!empty($imgFile)) {

            $upload_dir = 'user_images_berita/'; // upload directory
    
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
            // rename uploading image using random generator
            $userpic = uniqid('', true).".".$imgExt;
                
            // allow valid image file formats
            if(in_array($imgExt, $valid_extensions)){           
                // Check file size '5MB'
                if($imgSize < 5000000)              {
                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                }
                else{
                    $errMSG = "Sorry, your file is too large.";
                }
            }
            else{
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";        
            }
        
    } else {
        $userpic = placeholder.".".png;
    }

    if(!isset($errMSG))
    {
        if($crud->create($buserid,$bjudul,$bdeskripsi,$userpic,$bnamapen))
        {
        header("Location: add-berita.php?inserted");
        }
        else
        {
        header("Location: add-berita.php?failure");
        } 
    } 
}
?>

<div class="clearfix"></div>

<?php
    if(isset($_GET['inserted']))
    {
     ?>
        <div class="container">
            <div class="alert alert-info">
            <strong>SUCCESS!</strong>Berita was inserted successfully <a href="berita.php">HOME</a>!
            </div>
        </div>
    <?php
    }
    else if(isset($_GET['failure']))
    {
    ?>
        <div class="container">
             <div class="alert alert-warning">
                <strong>FAILED!</strong> ERROR while inserting record !
             </div>
        </div>
    <?php
    }
?>

<div class="clearfix"></div><br />

<div class="container">
    <?php
    if(isset($errMSG)){
            ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
                </div>
            <?php
    }
    ?> 
  
    <form method="post" enctype="multipart/form-data">

        <div class="col-xs-8">
            <label>Gambar (JPEG, JPG, PNG, GIF) *Optional</label>          
            <input class="input-group" type="file" name="user_image" accept="image/*" />
        </div>

        <div class="col-xs-8">
            <label>Judul</label>          
            <input type='text' name='txt_judul' class='form-control' maxlength="80" required>
        </div>

        <div class="col-md-8">
        <label>Deskripsi</label>
        <textarea class="form-control" rows="40"  wrap="hard" cols="80" name="txt_deskripsi" id="deskripsi" name="txt_deskripsi" required></textarea>
        </div>
        
        <div class="col-xs-8" style="display: none;">
            <br>
            <input type='hidden' name='txt_userid' class='form-control' value='<?php echo $userRow['userId'] ?>' readonly>
        </div>

        <div class="col-xs-8" style="display: none;">
            <br>
            <input type='hidden' name='txt_namapen' class='form-control' value='<?php echo $userRow['fullname'] ?>' readonly>
        </div>
        <br>

        <div class="col-xs-8">
            <button type="submit" class="btn btn-primary" name="btn-save">
                <span class="glyphicon glyphicon-plus"></span> Create New Record
            </button>  
            <a href="berita.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
        </div>

    </form>
         
</div>

<?php include_once 'footer.php'; ?>