<?php
require_once "classes/class.crud.pengeluaran.php";
$page=3;
$pengeluaran = new Pengeluaran();

if(isset($_POST['btn-del']))
{
    $id = $_GET['delete_id'];
    if($pengeluaran->delete($id)) {
        header("Location: delete-pengeluaran.php?deleted");
    }else{
        header("Location: delete-pengeluaran.php?failure");
    }
}

?>

<?php include_once 'views/header.php'; ?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
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
            elseif(isset($_GET['failure'])){
                ?>
                <div class="alert alert-warning">
                    <strong>Gagal !</strong> data tidak dapat dihapus karena Anda memiliki pengeluaran harian pada komponen ini.
                </div>
                <?php
            }
            elseif(isset($_GET['delete_id']) && !empty($_GET['delete_id']))
            {
                $id = $_GET['delete_id'];
                extract($pengeluaran->getID($id));
                if ($userId != $userRow['userId'] OR isset($_GET['delete_id']) == "" OR $namaKomp == null)
                {
                    exit("<div class='alert alert-danger'><span>Page not found!</span></div>");
                }
                ?>
                <div class="alert alert-danger">
                    <strong>Warning !</strong> remove the following record ?
                </div>
                <?php
            }
            else
            {
                exit("<div class='alert alert-danger'><span>Page not found!</span></div>");
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
                        <th>Komponen Pengeluaran</th>
                        <th>Batas Pengeluaran</th>
                        <th>Periode</th>
                    </tr>
                    <?php
                    $stmt = $pengeluaran->db->prepare("SELECT * FROM komppengeluaran WHERE kompId=:id");
                    $stmt->execute(array(":id"=>$_GET['delete_id']));
                    while($row=$stmt->fetch(PDO::FETCH_BOTH))
                    {
                        ?>
                        <tr>
                            <td><?php print($row['namaKomp']); ?></td>
                            <td><?php print($row['persenKomp']); ?></td>
                            <td align="right"><?php print $row['tglKomp']; ?></td>
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
                if(isset($_GET['delete_id']))
                {
                ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['kompId']; ?>" />
                <button class="btn btn-large btn-primary" type="submit" name="btn-del"><i class="glyphicon glyphicon-trash"></i> &nbsp; YES</button>
                <a href="view-pengeluaran.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; NO</a>
            </form>
            <?php
            }
            else
            {
                ?>
                <a href="view-pengeluaran.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
                <?php
            }
            ?>
            </p>
        </div>
    </div>
<?php include_once 'views/footer.php'; ?>