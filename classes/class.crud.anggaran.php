<?php
require_once ('routes/dbconfig.php');

class Anggaran{

    public $db;

    function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->db = $db;
    }

    public function create($kompId, $tglPngl, $anggaranPngl){
        try{

                $stmt = $this->db->prepare("INSERT INTO pengeluaran(kompId,tglPngl,anggaranPngl)
                  VALUES(:kompId, :tglPngl, :anggaranPngl )");
                $stmt->bindparam(":kompId", $kompId);
                $stmt->bindparam(":tglPngl", $tglPngl);
                $stmt->bindparam(":anggaranPngl", $anggaranPngl);
                $stmt->execute();

            return true;
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($id){
        $stmt = $this->db->prepare("SELECT komppengeluaran.namaKomp, komppengeluaran.userId FROM pengeluaran , komppengeluaran 
                                              WHERE komppengeluaran.kompId=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function update($id,$tglPngl, $anggaranPngl){
        try{
            $stmt=$this->db->prepare("UPDATE pengeluaran SET tglPngl=:tglPngl,
        anggaranPngl=:anggaranPngl
        WHERE Pengeluaran=:id ");
            $stmt->bindparam(":tglPngl",$tglPngl);
            $stmt->bindparam(":anggaranPngl",$anggaranPngl);
            $stmt->bindparam(":id",$id);
            $stmt->execute();

            return true;
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }


    public function delete($id)
    {
        $flag = '1';
        try{
            $stmt=$this->db->prepare("UPDATE pengeluaran SET flag=:flag
        WHERE pengeluaranId=:id ");
            $stmt->bindparam(":flag",$flag);
            $stmt->bindparam(":id",$id);
            $stmt->execute();

            return true;
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    /* paging */

    public function dataview($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>
                <div class="grid col-md-3" style=" padding: 10px 5px 0px 0px;">
                    <!--                    <div class="row" style="border: 1px solid lightgrey; margin: 20px 2px 0px 0px; padding: 10px;">-->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <?php print(strtoupper($row['namaKomp'])); ?>
                        </div>
                        <div class="panel-body">

                            <div style="font-size: 60px; text-align: center;">
                                <?php print($row['persenKomp']."%");  ?>
                            </div>
                            <span><hr></span>
                            <span >tes</span>
                        </div>
                        <div class="panel-footer">
                            <div align="center">
                                <a href="edit-pengeluaran.php?edit_id=<?php print($row['kompId']); ?>" class="btn btn-success btn-xs">Atur Anggaran</a>&nbsp;
                                <a href="edit-pengeluaran.php?edit_id=<?php print($row['kompId']); ?>" class="btn btn-warning btn-xs">Ubah</a>&nbsp;
                                <a href="edit-pengeluaran.php?delete_id=<?php print($row['kompId']); ?>" class="btn btn-danger btn-xs">Hapus</a>
                            </div>
                        </div>
                    </div>


                </div>
                <!--                <tr>-->
                <!---->
                <!--                    <td>--><?php //print($row['namaKomp']); ?><!--</td>-->
                <!--                    <td>--><?php //print($row['persenKomp']."%"); ?><!--</td>-->
                <!--                    <td align="center">-->
                <!--                                        <a href="edit-pengeluaran.php?edit_id=--><?php //print($row['kompId']); ?><!--"><i class="glyphicon glyphicon-edit"></i></a>-->
                <!--                    </td>-->
                <!--                    <td align="center">-->
                <!--                        <a href="delete-pengeluaran.php?delete_id=--><?php //print($row['kompId']); ?><!--"><i class="glyphicon glyphicon-remove-circle"></i></a>-->
                <!--                    </td>-->
                <!--                </tr>-->
                <?php
            }
        }
        else
        {
            ?>
            <tr>
                <td>Nothing here...</td>
            </tr>
            <?php
        }

    }

    public function paging($query,$records_per_page)
    {
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
            $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }
        $query2=$query." limit $starting_position,$records_per_page";
        return $query2;
    }

    public function paginglink($query,$records_per_page)
    {

        $self = $_SERVER['PHP_SELF'];

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $total_no_of_records = $stmt->rowCount();

        if($total_no_of_records > 0)
        {
            ?><ul class="pagination"><?php
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
                $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous =$current_page-1;
                echo "<li><a href='".$self."?page_no=1'>First</a></li>";
                echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
                }
                else
                {
                    echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
                echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
            }
            ?></ul><?php
        }
    }

    /* paging */

}

?>
