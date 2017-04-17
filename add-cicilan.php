<?php include_once 'views/header.php'; ?>
<?php
include_once 'classes/class.crud.cicilan.php';
$crud = new crud();

if(isset($_POST['btn-save']))
{
    $cuserid = $userRow['userId'];
    $cnamaCicilan = htmlspecialchars($_POST['txt_namacicilan']);
    $ctglMulai = strtotime($_POST['txt_tglMulai']);
    $ctglSelesai = strtotime($_POST['txt_tglSelesai']);
    $cjmlCicilan = $_POST['txt_jmlCicilan'];
    if($ctglMulai > $ctglSelesai)  {
        $error[] = "Tanggal Selesai harus lebih besar dari Tanggal Mulai";    
    }
    else
    {
        try
        {
            $ctglMulai2 = date("Y-m-d", $ctglMulai);
            $ctglSelesai2 = date("Y-m-d", $ctglSelesai);
            if($crud->create($cuserid,$cnamaCicilan,$ctglMulai2,$ctglSelesai2,$cjmlCicilan))
             {                   
                header("Location: add-cicilan.php?inserted");
             }
             else
             {
                header("Location: add-cicilan.php?failure");
             }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }   
}
?>

<div class="clearfix"></div><br />

<div class="container">
        <?php
            if(isset($error))
            {
                foreach($error as $error)
                {
                     ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
                }
            }
            else if(isset($_GET['inserted']))
            {
                 ?>
                 <div class="alert alert-info">
                      <strong>SUCCESS!</strong>cicilan berhasil ditambahkan <a href="view-cicilan.php">HOME</a>!
                 </div>
                 <?php
            }
        ?>
    <div class="col-md-6">          
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <div class="col-sm-4">
                    <label>Nama Cicilan</label>          
                </div>
                <div class="col-sm-8">
                    <input type='text' name='txt_namacicilan' class='form-control' maxlength="80" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4">
                    <label>Tanggal Mulai</label>          
                </div>
                <div class="col-sm-8">
                    <input id='datepicker' type='text' name='txt_tglMulai' class='form-control' required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4">
                    <label>Tanggal Selesai</label>          
                </div>
                <div class="col-sm-8">
                    <input id='datepicker2' type='text' name='txt_tglSelesai' class='form-control' required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4">
                    <label>Jumlah Cicilan / bln</label>          
                </div>
                <div class="col-sm-8">
                    <input type='text' name='txt_jmlCicilan' class='form-control' maxlength="30" onkeypress="return isNumberKey(event)" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary" name="btn-save">
                        <span class="glyphicon glyphicon-plus"></span> Create New Record
                    </button>  
                    <a href="cicilan.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
                </div>
            </div>

        </form>
    </div>     
</div>

<?php include_once 'views/footer.php'; ?>