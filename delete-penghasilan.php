<?php
include_once 'views/header.php';
require_once "classes/Penghasilan.php";
$page=2;
$penghasilan = new Penghasilan();

if(isset($_POST['btn-del']))
{
    $id = $_GET['delete_id'];
    $penghasilan->delete($id);
    header("Location: delete-penghasilan.php?deleted");
}


?>


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
            elseif(isset($_GET['delete_id']) && !empty($_GET['delete_id']))
            {
                $id = $_GET['delete_id'];
                extract($penghasilan->getID($id));
                if ($userId != $userRow['userId'] OR $sumberPghs === NULL OR isset($_GET['delete_id']) == "")
                {
                    exit("Page not Found");
                }
                ?>
                <div class="alert alert-danger">
                    <strong>Warning !</strong> remove the following record ?
                </div>
                <?php
            }
            else
            {
                exit("Page not found");
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
                    $stmt = $penghasilan->db->prepare("SELECT * FROM penghasilan WHERE penghasilanId=:id");
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
                <a href="view-penghasilan.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; NO</a>
            </form>
            <?php
            }
            else
            {
                ?>
                <a href="view-penghasilan.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
                <?php
            }
            ?>
            </p>
        </div>
    </div>
<?php include_once 'views/footer.php'; ?>