<?php
require_once "classes/class.crud.pengeluaran.php";
$page=3;
include_once "views/header.php";

$pengeluaran = new Pengeluaran();

if(empty($_GET['delete_id'])){
    $notFound="<div class='alert alert-danger'><span>Page not found!</span></div>";
}elseif (isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    extract($pengeluaran->getdetaileditID($id));
    if ($namaKomp === null) {
        $notFound="<div class='alert alert-danger'><span>Page not found!</span></div>";
    }
    elseif ($userId != $userRow['userId']) {
        $notFound="<div class='alert alert-danger'><span>Page not found!</span></div>";
    }
}

if(isset($_POST['btn-del']))
{
    $id = $_GET['delete_id'];
    $pengeluaran->deletedetail($id);
    header("Location: delete-detail.php?delete_id=".$id."&deleted");
}

?>

<?php include_once 'views/header.php'; ?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="clearfix"></div>

        <div class="container">

            <?php

            if (isset($notFound)){
                exit($notFound);
            }

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
                    <strong>Perhatian !</strong> Apakah anda yakin akan menghapus data di bawah ini?
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
                        <th>Nama Pengeluaran</th>
                        <th>Tanggal Pengeluaran</th>
                        <th>Nominal Pengeluaran</th>
                    </tr>
                    <?php
                    $stmt = $pengeluaran->db->prepare("SELECT * FROM detailpengeluaran WHERE detailPnglId=:id");
                    $stmt->execute(array(":id"=>$_GET['delete_id']));
                    while($row=$stmt->fetch(PDO::FETCH_BOTH))
                    {
                        ?>
                        <tr>
                            <td><?php print($row['namaDtlPngl']); ?></td>
                            <td><?php print($row['tglDtlPngl']); ?></td>
                            <td align="right"><?php print "Rp ".number_format($row['jmlDtlPngl'],2,',','.'); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </div>

        <div class="container">
            <p>
                <?php
                if(!(isset($_GET['delete_id']) && isset($_GET['deleted'])))
                {
                ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['detailPnglId']; ?>" />
                <button class="btn btn-large btn-primary" type="submit" name="btn-del"><i class="glyphicon glyphicon-trash"></i> &nbsp; YES</button>
                <a href="view-anggaran.php?kom_id=<?php echo $kompId?>" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; NO</a>
            </form>
            <?php
            }
            else
            {
                ?>
                <a href="view-anggaran.php?kom_id=<?php echo $kompId?>" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
                <?php
            }
            ?>
            </p>
        </div>
    </div>
<?php include_once 'views/footer.php'; ?>