<?php
include_once "classes/Penghasilan.php";
include_once "views/header.php";
$penghasilan = new Penghasilan();

if(isset($_GET['periode'])){
    $periode = explode("/",$_GET['periode']);
    $periode = $periode[0]."/01/".$periode[1];
    $periode = date('Y-m-d',strtotime($periode));
//    die(date('Y-m-d'));
}else{
    $periode = date('Y-m-d');
//    die(date('Y-m-d'));
}

if(isset($_POST['btn-periode'])){
    header("Location: view-penghasilan.php?periode=".$_POST['periode']);
}
?>

    <div class="clearfix"></div>

    <div class="container">
        <h1>Daftar Penghasilan</h1>
        <hr>
        <a href="add-penghasilan.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
        <hr>
        <form method="post">
            <div class="form form-horizontal">
                <label class="col-md-1 control-label" for="periode">Periode</label>
                <div class="col-md-2">
                    <input class="form-control date-picker" name="periode" readonly required value="<?php $dtp=explode("-",$periode); $dtp=$dtp[1]."/".$dtp[0]; echo $dtp?>">

                </div>
                <button class="btn btn-info" type="submit" name="btn-periode">Submit</button>

            </div>
        </form>
    </div>

    <div class="clearfix"></div><br />

    <div class="container">
        <table class='table table-bordered table-responsive'>
            <tr>
                <th>#</th>
                <th>Sumber Penghasilan</th>
                <th>Tanggal Penghasilan</th>
                <th>Nominal Penghasilan</th>
                <th colspan="2" align="center">Actions</th>
            </tr>
            <?php
            $query = "SELECT * FROM penghasilan WHERE flag='0' AND 
                        MONTH(tglPghs)=MONTH('".$periode."') AND
                        YEAR(tglPghs)=YEAR('".$periode."') AND
                        userId='".$userRow['userId']."'
                        ORDER BY tglPghs DESC";
            $records_per_page=5;
            $newquery = $penghasilan->paging($query,$records_per_page);
            $penghasilan->dataview($newquery);
            ?>
            <tr>
                <td colspan="3" align="center"><strong>Total</strong></td>
                <td align="right"><?php print "Rp &nbsp;".number_format($penghasilan->getTotalPenghasilan($userRow['userId'],$periode),2,'.',','); ?></td>
                <td colspan="2"></td>
            </tr>


        </table>


    </div>

<?php include_once 'views/footer.php'; ?>