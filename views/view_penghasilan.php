<?php
include_once $_SERVER['DOCUMENT_ROOT']."/pterpan/classes/Penghasilan.php";
include_once "header.php";
$penghasilan = new Penghasilan();
?>

    <div class="clearfix"></div>

    <div class="container">
        <a href="add-penghasilan.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
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
            $query = "SELECT * FROM penghasilan WHERE flag='0' AND userId='1'";
            $records_per_page=5;
            $newquery = $penghasilan->paging($query,$records_per_page);
            $penghasilan->dataview($newquery);
            ?>
            <tr>
                <td colspan="7" align="center">
                    <div class="pagination-wrap">
                        <?php $penghasilan->paginglink($query,$records_per_page); ?>
                    </div>
                </td>
            </tr>

        </table>


    </div>

<?php include_once 'footer.php'; ?>