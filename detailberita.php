<?php
include_once "views/header.php";
include_once 'classes/class.crud.berita.php';
$berita = new crud();

if(isset($_GET['detail_id']) == "")
{
    exit("Page not Found");
}
elseif(empty($_GET['detail_id'])) 
{ 
  exit("Page not Found");
}
elseif(isset($_GET['detail_id']))
{
    $id = $_GET['detail_id'];
    extract($berita->getID($id)); 
    if ($judul === NULL)
    {
        exit("Page not Found");
    } 
}

$tanggalbaru = date_create($tanggaldib);

?>
<link rel="stylesheet" href="css/homeberita.css" type="text/css"/>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="clearfix"></div><br />

    <div style="height:auto;background-color:white;margin-top:-22px;">    
    <div class="container">
        <div class ="col-md-8" style="margin-bottom:50px;margin-top:70px;">
            <h1><?php echo $judul; ?></h1>
            <h5>Posted on <?php echo date_format($tanggalbaru,"d/m/Y H:i:s"); ?></h5>
            <h5>By <?php echo $namapen; ?></h5>
            <br>
                
                <?php
                if ($gambar != 'placeholder.png'){ ?>
                <p>
                <img src="user_images_berita/<?php echo $gambar; ?>" style="width: 100%;" />
                </p>
                <?php
                }
                ?>
                 
            <br>
            <?php echo $deskripsi ?>

        </div>
      
    </div>
</div>
<?php include_once 'views/footer.php'; ?>