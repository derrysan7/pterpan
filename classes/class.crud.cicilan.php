<?php

require_once ('routes/dbconfig.php');

class crud
{
 private $db; 
 
 function __construct()
 {
    $database = new Database();
    $db = $database->dbConnection();
    $this->db = $db;
 }
 
 public function create($cuserid,$cnamaCicilan,$ctglMulai,$ctglSelesai,$cjmlCicilan)
 {
  try
  {
   $stmt = $this->db->prepare("INSERT INTO cicilan(userId,tglDibuat,namaCicilan,tglMulai,tglSelesai,jmlCicilan) 
                                                   VALUES(:cuserid,CURRENT_TIMESTAMP(),:cnamaCicilan,:ctglMulai,:ctglSelesai,:cjmlCicilan)");
   $stmt->bindparam(":cuserid", $cuserid);
   $stmt->bindparam(":cnamaCicilan", $cnamaCicilan);
   $stmt->bindparam(":ctglMulai", $ctglMulai);
   $stmt->bindparam(":ctglSelesai", $ctglSelesai);
   $stmt->bindparam(":cjmlCicilan", $cjmlCicilan);
   $stmt->execute();
   return true;
  }
  catch(PDOException $e)
  {
   echo $e->getMessage(); 
   return false;
  }
  
 }
 
 public function getID($id)
 {
  $stmt = $this->db->prepare("SELECT * FROM cicilan WHERE cicilanId=:id");
  $stmt->execute(array(":id"=>$id));
  $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
  return $editRow;
 }
 
 public function update($id,$cnamaCicilan,$ctglMulai,$ctglSelesai,$cjmlCicilan)
 {
  try
  {
   $stmt=$this->db->prepare("UPDATE cicilan SET namaCicilan=:cnamaCicilan,  
                                              tglMulai=:ctglMulai,
                                              tglSelesai=:ctglSelesai,
                                              jmlCicilan=:cjmlCicilan
             WHERE cicilanId=:id ");
   $stmt->bindparam(":id",$id);
   $stmt->bindparam(":cnamaCicilan", $cnamaCicilan);
   $stmt->bindparam(":ctglMulai", $ctglMulai);
   $stmt->bindparam(":ctglSelesai", $ctglSelesai);
   $stmt->bindparam(":cjmlCicilan", $cjmlCicilan);  
   $stmt->execute();
   
   return true; 
  }
  catch(PDOException $e)
  {
   echo $e->getMessage(); 
   return false;
  }
 }
 
 public function delete($id)
 {
  $stmt = $this->db->prepare("DELETE FROM cicilan WHERE cicilanId=:id");
  $stmt->bindparam(":id",$id);
  $stmt->execute();
  return true;
 }

public function lastID()
  {
    $stmt = $this->db->lastInsertId();
    return $stmt;
  }

 public function create_detail($ccicilanId,$ctglCicilan)
 {
  try
  {
   $stmt = $this->db->prepare("INSERT INTO detailcicilan(cicilanId,tglCicilan) 
                                                   VALUES(:ccicilanId,:ctglCicilan)");
   $stmt->bindparam(":ccicilanId", $ccicilanId);
   $stmt->bindparam(":ctglCicilan", $ctglCicilan);
   $stmt->execute();
   return true;
  }
  catch(PDOException $e)
  {
   echo $e->getMessage(); 
   return false;
  }
  
 }

public function add_month($date_str,$months)
  {
      $date = new DateTime($date_str);

      // We extract the day of the month as $start_day
      $start_day = $date->format('j');

      // We add 1 month to the given date
      $date->modify("+{$months} month");

      // We extract the day of the month again so we can compare
      $end_day = $date->format('j');

      if ($start_day != $end_day)
      {
          // The day of the month isn't the same anymore, so we correct the date
          $date->modify('last day of last month');
      }

      $result = $date->format('Y-m-d');

      return $result;
  }

 public function delete_detail($cicilanId)
 {
  $stmt = $this->db->prepare("DELETE FROM detailcicilan WHERE cicilanId=:cicilanId");
  $stmt->bindparam(":cicilanId",$cicilanId);
  $stmt->execute();
  return true;
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
            <td><?php print($row['cicilanId']); ?></td>
            <td><?php print($row['namaCicilan']); ?></td>
            <td><?php $tglMulaiPrint = date("d/m/Y", strtotime($row['tglMulai'])); print($tglMulaiPrint); ?></td>
            <td><?php $tglSelesaiPrint = date("d/m/Y", strtotime($row['tglSelesai'])); print($tglSelesaiPrint); ?></td>
            <td style="text-align:right"><?php print("Rp ". number_format($row['jmlCicilan'],2,',','.')); ?></td>
            <td align="center">
            <a href="edit-cicilan.php?edit_id=<?php print($row['cicilanId']); ?>"><i class="glyphicon glyphicon-edit"></i></a>
            </td>
            <td align="center">
            <a href="delete-cicilan.php?delete_id=<?php print($row['cicilanId']); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
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