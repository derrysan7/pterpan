<?php
require_once $_SERVER['DOCUMENT_ROOT']."/pterpan/classes/Penghasilan.php";
$penghasilan = new Penghasilan();

if(isset($_POST['btn-del']))
{
    $id = $_GET['delete_id'];
    $penghasilan->delete($id);
    header("Location: delete.php?deleted");
}

?>

<?php include_once 'header.php'; ?>

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
                <strong>Sure !</strong> to remove the following record ?
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
                    <th>#</th>
                    <th>Sumber Penghasilan</th>
                    <th>Tanggal Penghasilan</th>
                    <th>Nominal Penghasilan</th>
                </tr>
                <?php
                $stmt = $DB_con->prepare("SELECT * FROM penghasilan WHERE penghasilanId=:id");
                $stmt->execute(array(":id"=>$_GET['delete_id']));
                while($row=$stmt->fetch(PDO::FETCH_BOTH))
                {
                    ?>
                    <tr>
                        <td><?php print($row['penghasilanId']); ?></td>
                        <td><?php print($row['sumberPghs']); ?></td>
                        <td><?php print($row['tglPghs']); ?></td>
                        <td align="right"><?php print("Rp ".$row['nominalPghs']); ?></td>
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
            <input type="hidden" name="id" value="<?php echo $row['Penghasilanid']; ?>" />
            <button class="btn btn-large btn-primary" type="submit" name="btn-del"><i class="glyphicon glyphicon-trash"></i> &nbsp; YES</button>
            <a href="../views/view-penghasilan.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; NO</a>
        </form>
        <?php
        }
        else
        {
            ?>
            <a href="../views/view-penghasilan.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
            <?php
        }
        ?>
        </p>
    </div>
<?php include_once 'footer.php'; ?>