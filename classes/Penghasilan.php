<?php
require_once ('routes/dbconfig.php');

class Penghasilan{

    public $db;

    function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->db = $db;
    }

    public function tot_penghasilan($userId)
    {
        $stmt = $this->db->prepare("SELECT SUM(nominalPghs) nomPenghasilan FROM penghasilan WHERE userId=:userId AND flag='0'");
        $stmt->bindparam(":userId",$userId);
        $stmt->execute();
        $tot_peng = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tot_peng;
    }

    public function lap_penghasilan($userId){
        $stmt = $this->db->prepare("SELECT sumberPghs,nominalPghs FROM penghasilan WHERE userId=:userId AND flag='0'");
        $stmt->bindparam(":userId",$userId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_NUM);
        return $results;
    }

    public function json_chart($userId)
    {
        $stmt = $this->db->prepare("SELECT sumberPghs,nominalPghs FROM penghasilan WHERE flag='0' AND userId=:userId");
        $stmt->bindparam(":userId",$userId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_NUM);
        return $results;
    }

    public function create($userId,$sumberPghs, $tglPghs, $nominalPghs){
        try{
            $stmt = $this->db->prepare("INSERT INTO penghasilan(userId,sumberPghs,tglPghs,nominalPghs)
      VALUES(:userId, :sumberPghs, :tglPghs, :nominalPghs)");
            $stmt->bindparam(":userId",$userId);
            $stmt->bindparam(":sumberPghs",$sumberPghs);
            $stmt->bindparam(":tglPghs",$tglPghs);
            $stmt->bindparam(":nominalPghs",$nominalPghs);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($id){
        $stmt = $this->db->prepare("SELECT * FROM penghasilan WHERE penghasilanId=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function update($id,$sumberPghs, $tglPghs, $nominalPghs){
        try{
            $stmt=$this->db->prepare("UPDATE penghasilan SET sumberPghs=:sumberPghs,
        tglPghs=:tglPghs,
        nominalPghs=:nominalPghs
        WHERE penghasilanId=:id ");
            $stmt->bindparam(":sumberPghs",$sumberPghs);
            $stmt->bindparam(":tglPghs",$tglPghs);
            $stmt->bindparam(":nominalPghs",$nominalPghs);
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
            $stmt=$this->db->prepare("UPDATE penghasilan SET flag=:flag
        WHERE penghasilanId=:id ");
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
                <tr>
                    <td><?php print($row['penghasilanId']); ?></td>
                    <td><?php print($row['sumberPghs']); ?></td>
                    <td><?php print($row['tglPghs']); ?></td>
                    <td align="right"><?php print("Rp ".$row['nominalPghs']); ?></td>
                    <td align="center">
                        <a href="edit-penghasilan.php?edit_id=<?php print($row['penghasilanId']); ?>"><i class="glyphicon glyphicon-edit"></i></a>
                    </td>
                    <td align="center">
                        <a href="delete-penghasilan.php?delete_id=<?php print($row['penghasilanId']); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
                    </td>
                </tr>
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
