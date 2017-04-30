<?php
require_once ('routes/dbconfig.php');

class Pengeluaran{

    public $db;

    function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->db = $db;
    }

    public function Pghsisset($userId){
        $stmt = $this->db->prepare("SELECT * FROM penghasilan WHERE userId=:userId AND MONTH(tglPghs) = MONTH(CURRENT_DATE ())");
        $stmt->bindParam(":userId",$userId);
        $stmt->execute();
        if ($stmt->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function create($userId,$namaKomp,$tipePngl,$tglKomp,$persenKomp){
    try{
        for ($i = 0; $i < sizeof($namaKomp);$i++) {

            if ($tipePngl[$i]=="true"){
                $tipe = "cicilan";
            }else{
                $tipe="detil";
            }


            $stmt = $this->db->prepare("INSERT INTO komppengeluaran(userId,namaKomp,tipePngl,tglKomp,persenKomp)
                  VALUES(:userId, :namaKomp,:tipePngl,:tglKomp,:persenKomp )");
            $stmt->bindparam(":userId", $userId);
            $stmt->bindparam(":namaKomp", $namaKomp[$i]);
            $stmt->bindparam(":tipePngl", $tipe);
            $stmt->bindparam(":tglKomp", $tglKomp);
            $stmt->bindparam(":persenKomp", $persenKomp[$i]);
            $stmt->execute();

            $getKomp = $this->db->prepare("SELECT kompId,persenKomp FROM komppengeluaran ORDER BY kompId DESC LIMIT 1");
            $getKomp->execute();
            $currentKomp = $getKomp->fetch(PDO::FETCH_ASSOC);

            $getPenghasilan = $this->db->prepare("SELECT SUM(nominalPghs) total FROM penghasilan WHERE userId = :userId AND MONTH(tglPghs)=MONTH(CURRENT_DATE())");
            $getPenghasilan->bindparam(":userId",$userId);
            $getPenghasilan->execute();
            $currentPenghasilan = $getPenghasilan->fetch(PDO::FETCH_ASSOC);

            $anggaranPngl = (($currentKomp['persenKomp']/100) * $currentPenghasilan['total']);

                $stmt2 = $this->db->prepare("INSERT INTO pengeluaran(kompId,anggaranPngl)
                  VALUES(:kompId, :anggaranPngl )");
            $stmt2->bindparam(":kompId", $currentKomp['kompId']);
            $stmt2->bindparam(":anggaranPngl", $anggaranPngl);
            $stmt2->execute();
        }
        return true;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

public function getID($id){
    $stmt = $this->db->prepare("SELECT * FROM komppengeluaran WHERE kompId=:id");
    $stmt->execute(array(":id"=>$id));
    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    return $editRow;
}

public function update($id,$namaKomp,$tipePngl,$tglKomp,$persenKomp){
    try{
        if ($tipePngl=="true"){
            $tipe = "cicilan";
        }else{
            $tipe="detil";
        }

        $stmt=$this->db->prepare("UPDATE komppengeluaran SET namaKomp=:namaKomp,
        persenKomp=:persenKomp,tipePngl=:tipePngl,tglKomp=:tglKomp
        WHERE kompId=:id ");
        $stmt->bindparam(":namaKomp",$namaKomp);
        $stmt->bindparam(":persenKomp",$persenKomp);
        $stmt->bindparam(":tipePngl",$tipe);
        $stmt->bindparam(":tglKomp",$tglKomp);
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
        $stmt=$this->db->prepare("UPDATE komppengeluaran SET flag=:flag
        WHERE kompId=:id ");
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
                <div class="panel panel-primary">
                    <div class="panel-heading col-md-12">
                        <!--                            <div class="row">-->
                        <div class="col-md-6">
                            <?php print(strtoupper($row['namaKomp'])); ?>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                            <strong><?php print($row['persenKomp']."%");  ?></strong>
                        </div>
                        <!--                            </div>-->
                    </div>
                    <div class="panel-body">



                        <div style="font-size: 20px;text-align: center; padding-top: 45px;">

                            <?php

                            $stmt2 = $this->db->prepare("SELECT anggaranPngl FROM pengeluaran WHERE flag='0' AND kompId='".$row['kompId']."'");
                            $stmt2->execute();

                            $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
                            if(isset($row2['anggaranPngl'])){

                                echo "Rp &nbsp". number_format($row2['anggaranPngl'],2,',','.');


                            }else{
                                echo "-";
                            }
                            ?>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <div align="center">
                            <a href="add-anggaran.php?kom_id=<?php print($row['kompId']); ?>" class="btn btn-success btn-xs">Atur Anggaran</a>&nbsp;
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
