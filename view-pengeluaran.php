<?php
include_once "classes/class.crud.pengeluaran.php";
include_once "views/header.php";
$pengeluaran = new Pengeluaran();
?>

    <div class="clearfix"></div>

    <div class="container">
        <h1>Komponen Pengeluaran</h1>
        <hr>
        <a href="add-pengeluaran.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
    </div>

    <div class="clearfix"></div><br />

    <div class="container">
<!--        <table class='table table-bordered table-responsive'>-->
<!--            <tr>-->
<!---->
<!--                <th>Komponen Pengeluaran</th>-->
<!--                <th>Batas Anggaran</th>-->
<!--                <th colspan="2" align="center">Actions</th>-->
<!--            </tr>-->
            <?php
            $query = "SELECT * FROM kompPengeluaran WHERE flag='0' AND userId='".$userRow['userId']."'ORDER BY namaKomp ASC";
            $records_per_page=5;
            $newquery = $pengeluaran->paging($query,$records_per_page);
            $pengeluaran->dataview($newquery);
            ?>
<!--            <tr>-->
<!--                <td colspan="7" align="center">-->
<!--                    <div class="pagination-wrap">-->
<!--                        --><?php //$pengeluaran->paginglink($query,$records_per_page); ?>
<!--                    </div>-->
<!--                </td>-->
<!--            </tr>-->
<!---->
<!--        </table>-->


    </div>

<?php include_once 'views/footer.php'; ?>