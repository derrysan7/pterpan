<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php $page=3; include_once 'views/header.php'; ?>
<?php
include_once 'classes/class.crud.cicilan.php';
$crud = new crud();
$notfound="<div class='alert alert-danger'><span>Page not found!</span></div>";

if(isset($_POST['btn-update']))
{
    $id = $_GET['edit_id'];
    extract($crud->getID($id));
    $cuserid = $userRow['userId'];
    $cnamaCicilan = htmlspecialchars($_POST['txt_namacicilan']);
    $ctglMulai = $_POST['txt_tglMulai'];
    $ctglSelesai = $_POST['txt_tglSelesai'];
    $cjmlCicilan = $_POST['txt_jmlCicilan'];
    if(strtotime($ctglMulai) > strtotime($ctglSelesai))  
    {
        $error[] = "Tanggal Selesai harus lebih besar dari Tanggal Mulai";    
    }
    elseif (strtotime($ctglMulai) == strtotime($ctglSelesai))
    {
        $error[] = "Tanggal Selesai tidak boleh sama dengan Tanggal Mulai";  
    }
    else
    {
        try
        {
            $ctglMulai2 = date("Y-m-d", strtotime($ctglMulai));
            $ctglSelesai2 = date("Y-m-d", strtotime($ctglSelesai));
            if($crud->update($id,$cnamaCicilan,$ctglMulai2,$ctglSelesai2,$cjmlCicilan))
             {
                $crud->delete_detail($id);
                $month = 1;
                while (strtotime($ctglMulai2) <= strtotime($ctglSelesai2))
                {
                    $crud->create_detail($id,$ctglMulai2);
                    $ctglMulai2 = $crud->add_month($ctglMulai,$month);
                    $month = $month + 1;
                }
                $msg = "<div class='alert alert-info'>
                    <strong>Success!</strong> Cicilan berhasil diedit!
                    </div>";
             }
             else
             {
                $msg = "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Cicilan gagal diedit !
                    </div>";
             }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }   
}

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<?php
if(isset($_GET['edit_id']) == "")
{
    exit($notfound);
}
elseif(empty($_GET['edit_id'])) 
{ 
  exit($notfound);
}
elseif(isset($_GET['edit_id']))
{
    $id = $_GET['edit_id'];
    extract($crud->getID($id)); 
    if ($namaCicilan === NULL)
    {
        exit($notfound);
    } 
    elseif ($userId != $userRow['userId'])
    {
        exit($notfound);
    }
}

$tglMulai = date("m/d/Y", strtotime($tglMulai));
$tglSelesai = date("m/d/Y", strtotime($tglSelesai));
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
        <h2>Edit Cicilan <?php echo $namaCicilan ?></h2>
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
                
            ?>
        <div class="col-md-6">          
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <div class="col-sm-4">
                        <label>Nama Cicilan</label>          
                    </div>
                    <div class="col-sm-8">
                        <input type='text' name='txt_namacicilan' class='form-control' maxlength="80" value="<?php echo $namaCicilan ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4">
                        <label>Tanggal Mulai</label>          
                    </div>
                    <div class="col-sm-8">
                        <input id='datepicker' type='text' name='txt_tglMulai' class='form-control' value="<?php echo $tglMulai ?>" readonly='true' required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4">
                        <label>Tanggal Selesai</label>          
                    </div>
                    <div class="col-sm-8">
                        <input id='datepicker2' type='text' name='txt_tglSelesai' class='form-control' value="<?php echo $tglSelesai ?>" readonly='true' required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4">
                        <label>Jumlah Cicilan / bln</label>          
                    </div>
                    <div class="col-sm-8">
                        <input type='text' name='txt_jmlCicilan' class='form-control' maxlength="30" onkeypress="return isNumberKey(event)" value="<?php echo $jmlCicilan ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary" name="btn-update">
                            <span class="glyphicon glyphicon-edit"></span>  Update this Record
                        </button>  
                        <a href="view-cicilan.php?kom_id=<?php echo $kompId ?>" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
                    </div>
                </div>

            </form>
        </div>     
    </div>
</div>
<?php include_once 'views/footer.php'; ?>