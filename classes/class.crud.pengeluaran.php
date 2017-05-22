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
        $stmt = $this->db->prepare("SELECT * FROM penghasilan WHERE flag='0' AND userId=:userId AND MONTH(tglPghs) = MONTH(CURRENT_DATE ())");
        $stmt->bindParam(":userId",$userId);
        $stmt->execute();
        if ($stmt->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function cekPersen($userId,$tglKomp,$persenKomp){
        $stmt = $this->db->prepare("SELECT SUM(persenKomp) total FROM komppengeluaran 
                                    WHERE MONTH(tglKomp)=MONTH(:tglKomp) AND
                                    userId=:userId AND
                                    flag='0'");
        $stmt->bindParam(":tglKomp",$tglKomp);
        $stmt->bindParam(":userId",$userId);
        $stmt->execute();
        if ($stmt->rowCount()>0){
            $results=$stmt->fetch(PDO::FETCH_ASSOC);
            if(($results['total'] + $persenKomp)>100){
                return false;
            }else{
                return true;
            }
        }
    }

    public function cekDtlPnglEdit($userId,$detailPnglId,$tglDtlPngl){
        $stmt = $this->db->prepare("SELECT SUM(jmlDtlPngl) total FROM komppengeluaran,pengeluaran,detailpengeluaran 
                                    WHERE MONTH(komppengeluaran.tglKomp)=MONTH(:tglDtlPngl) 
                                    AND komppengeluaran.kompId = pengeluaran.kompId
                                    AND pengeluaran.pengeluaranId = detailpengeluaran.pengeluaranId
                                    AND detailpengeluaran.detailPnglId != :detailId
                                    AND komppengeluaran.userId=:userId
                                    AND detailpengeluaran.flag='0'");
        $stmt->bindParam(":tglDtlPngl",$tglDtlPngl);
        $stmt->bindParam(":userId",$userId);
        $stmt->bindParam(":detailId",$detailPnglId);
        $stmt->execute();
        if ($stmt->rowCount()>0){
            $results=$stmt->fetch(PDO::FETCH_ASSOC);
            return $results['total'];

        }
    }

    public function cekPersenEdit($userId,$tglKomp,$persenKomp,$kompId)
    {

        $stmt = $this->db->prepare("SELECT SUM(persenKomp) total FROM komppengeluaran 
                                    WHERE MONTH(tglKomp)=MONTH(:tglKomp) AND
                                    userId=:userId AND
                                    flag='0' AND 
                                    kompId != :kompId");
        $stmt->bindParam(":tglKomp", $tglKomp);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":kompId", $kompId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            if (($results['total'] + $persenKomp) > 100) {
                return false;
            } else {
                return true;
            }
        }
    }
    public function json_chart($userId,$date_now,$month_now,$year_now)
    {
        $stmt = $this->db->prepare("SELECT komppengeluaran.kompId,namaKomp,persenKomp,anggaranPngl Anggaran,SUM(jmlDtlPngl) Realisasi
                                    FROM komppengeluaran,pengeluaran,detailpengeluaran
                                    WHERE userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND pengeluaran.pengeluaranId=detailpengeluaran.pengeluaranId AND detailpengeluaran.flag='0' AND komppengeluaran.flag='0' AND MONTH(tglKomp)=:month_now AND YEAR(tglKomp)=:year_now
                                    GROUP BY kompId
                                    UNION
                                    SELECT komppengeluaran.kompId,namaKomp,persenKomp,anggaranPngl Anggaran,SUM(jmlCicilan) Realisasi
                                    FROM komppengeluaran,pengeluaran,cicilan
                                    WHERE komppengeluaran.userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND komppengeluaran.kompId = cicilan.kompId AND cicilan.flag='0' AND komppengeluaran.flag='0' AND tglSelesai >= :date_now AND tglMulai <= :date_now
                                    GROUP BY kompId");
        $stmt->bindparam(":userId",$userId);
        $stmt->bindparam(":date_now",$date_now);
        $stmt->bindparam(":month_now",$month_now);
        $stmt->bindparam(":year_now",$year_now);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_NUM);
        return $results;
    }

    public function json_chart_persen($userId,$nomPenghasilan,$date_now,$month_now,$year_now)
    {
        $stmt = $this->db->prepare("SELECT komppengeluaran.kompId,namaKomp,persenKomp,FORMAT((anggaranPngl/:nomPenghasilan*100),0) Anggaran,FORMAT((SUM(jmlDtlPngl)/:nomPenghasilan*100),0) Realisasi
                                    FROM komppengeluaran,pengeluaran,detailpengeluaran
                                    WHERE userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND pengeluaran.pengeluaranId=detailpengeluaran.pengeluaranId AND detailpengeluaran.flag='0' AND komppengeluaran.flag='0' AND MONTH(tglKomp)=:month_now AND YEAR(tglKomp)=:year_now
                                    GROUP BY kompId
                                    UNION
                                    SELECT komppengeluaran.kompId,namaKomp,persenKomp,FORMAT((anggaranPngl/:nomPenghasilan*100),0) Anggaran,FORMAT((SUM(jmlCicilan)/:nomPenghasilan*100),0) Realisasi
                                    FROM komppengeluaran,pengeluaran,cicilan
                                    WHERE komppengeluaran.userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND komppengeluaran.kompId = cicilan.kompId AND cicilan.flag='0' AND komppengeluaran.flag='0' AND tglSelesai >= :date_now AND tglMulai <= :date_now
                                    GROUP BY kompId");
        $stmt->bindparam(":userId",$userId);
        $stmt->bindparam(":nomPenghasilan",$nomPenghasilan);
        $stmt->bindparam(":date_now",$date_now);
        $stmt->bindparam(":month_now",$month_now);
        $stmt->bindparam(":year_now",$year_now);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_NUM);
        return $results;
    }

    public function lap_komp_pengeluaran($userId,$date_now,$month_now,$year_now){
        $stmt = $this->db->prepare("SELECT komppengeluaran.kompId,namaKomp
                                    FROM komppengeluaran,pengeluaran,detailpengeluaran
                                    WHERE userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND pengeluaran.pengeluaranId=detailpengeluaran.pengeluaranId AND detailpengeluaran.flag='0' AND komppengeluaran.flag='0' AND MONTH(tglKomp)=:month_now AND YEAR(tglKomp)=:year_now
                                    GROUP BY kompId
                                    UNION
                                    SELECT komppengeluaran.kompId,namaKomp
                                    FROM komppengeluaran,pengeluaran,cicilan
                                    WHERE komppengeluaran.userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND komppengeluaran.kompId = cicilan.kompId AND cicilan.flag='0' AND komppengeluaran.flag='0' AND tglSelesai >= :date_now AND tglMulai <= :date_now
                                    GROUP BY kompId
                                    ORDER BY kompId");
        $stmt->bindparam(":userId",$userId);
        $stmt->bindparam(":date_now",$date_now);
        $stmt->bindparam(":month_now",$month_now);
        $stmt->bindparam(":year_now",$year_now);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_NUM);
        return $results;
    }
    public function lap_detail_pengeluaran($userId,$kompId,$date_now,$month_now,$year_now){
        $stmt = $this->db->prepare("SELECT komppengeluaran.kompId,namaKomp,namaDtlPngl Nama_Detail,jmlDtlPngl Realisasi
                                    FROM komppengeluaran,pengeluaran,detailpengeluaran
                                    WHERE userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND pengeluaran.pengeluaranId=detailpengeluaran.pengeluaranId AND detailpengeluaran.flag='0' AND komppengeluaran.flag='0' AND komppengeluaran.kompId=:kompId AND MONTH(tglKomp)=:month_now AND YEAR(tglKomp)=:year_now
                                    UNION
                                    SELECT komppengeluaran.kompId,namaKomp,namaCicilan Nama_Detail,jmlCicilan Realisasi
                                    FROM komppengeluaran,pengeluaran,cicilan
                                    WHERE komppengeluaran.userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND komppengeluaran.kompId = cicilan.kompId AND cicilan.flag='0' AND komppengeluaran.flag='0' AND komppengeluaran.kompId=:kompId AND tglSelesai >= :date_now AND tglMulai <= :date_now
                                    ORDER BY kompId");
        $stmt->bindparam(":userId",$userId);
        $stmt->bindparam(":kompId",$kompId);
        $stmt->bindparam(":date_now",$date_now);
        $stmt->bindparam(":month_now",$month_now);
        $stmt->bindparam(":year_now",$year_now);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_NUM);
        return $results;
    }

    public function tot_pengeluaran($userId,$date_now,$month_now,$year_now)
    {
        $stmt = $this->db->prepare("SELECT SUM(Realisasi) Total_Realisasi FROM(
                                    SELECT SUM(jmlDtlPngl) AS Realisasi
                                    FROM komppengeluaran,pengeluaran,detailpengeluaran
                                    WHERE userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND pengeluaran.pengeluaranId=detailpengeluaran.pengeluaranId AND detailpengeluaran.flag='0' AND komppengeluaran.flag='0' AND MONTH(tglKomp)=:month_now AND YEAR(tglKomp)=:year_now
                                    UNION
                                    SELECT SUM(jmlCicilan) AS Realisasi
                                    FROM komppengeluaran,pengeluaran,cicilan
                                    WHERE komppengeluaran.userId=:userId AND komppengeluaran.kompId=pengeluaran.kompId AND komppengeluaran.kompId = cicilan.kompId AND cicilan.flag='0' AND komppengeluaran.flag='0' AND tglSelesai >= :date_now AND tglMulai <= :date_now
                                    ) t1");
        $stmt->bindparam(":userId",$userId);
        $stmt->bindparam(":date_now",$date_now);
        $stmt->bindparam(":month_now",$month_now);
        $stmt->bindparam(":year_now",$year_now);
        $stmt->execute();
        $tot_peng = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tot_peng;
    }

    public function create($userId,$namaKomp,$tipePngl,$tglKomp,$persenKomp){
        try{



            if ($tipePngl=="true"){
                $tipe = "cicilan";
            }else{
                $tipe="detil";
            }

            if($this->cekPersen($userId,$tglKomp,$persenKomp)){


//                $stmt = $this->db-prepare


                $stmt = $this->db->prepare("INSERT INTO komppengeluaran(userId,namaKomp,tipePngl,tglKomp,persenKomp)
                  VALUES(:userId, :namaKomp,:tipePngl,:tglKomp,:persenKomp )");
                $stmt->bindparam(":userId", $userId);

                $stmt->bindparam(":namaKomp", $namaKomp);
                $stmt->bindparam(":tipePngl", $tipe);
                $stmt->bindparam(":tglKomp", $tglKomp);
                $stmt->bindparam(":persenKomp", $persenKomp);

                $stmt->execute();

                $getKomp = $this->db->prepare("SELECT kompId,persenKomp FROM komppengeluaran ORDER BY kompId DESC LIMIT 1");
                $getKomp->execute();
                $currentKomp = $getKomp->fetch(PDO::FETCH_ASSOC);

                $getPenghasilan = $this->db->prepare("SELECT SUM(nominalPghs) total FROM penghasilan WHERE flag='0' AND userId = :userId AND MONTH(tglPghs)=MONTH(CURRENT_DATE()) AND flag='0'");

                $getPenghasilan->bindparam(":userId",$userId);
                $getPenghasilan->execute();
                $currentPenghasilan = $getPenghasilan->fetch(PDO::FETCH_ASSOC);

                $anggaranPngl = (($currentKomp['persenKomp']/100) * $currentPenghasilan['total']);

                $stmt2 = $this->db->prepare("INSERT INTO pengeluaran(kompId,anggaranPngl)
                  VALUES(:kompId, :anggaranPngl )");
                $stmt2->bindparam(":kompId", $currentKomp['kompId']);
                $stmt2->bindparam(":anggaranPngl", $anggaranPngl);
                $stmt2->execute();


                return true;

            }else{
                return false;
            }



      
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }


    public function createDetail($userId,$pengeluaranId,$namaDtlPngl,$jmlDtlPngl,$tglDtlPngl)
    {
        try {

            if (($this->currentBalance($userId))-$jmlDtlPngl>=0){

                $stmt = $this->db->prepare("INSERT INTO detailpengeluaran(pengeluaranId,namaDtlPngl,jmlDtlPngl,tglDtlPngl)
                  VALUES(:pengeluaranId,:namaDtlPngl,:jmlDtlPngl,:tglDtlPngl)");
                $stmt->bindparam(":pengeluaranId", $pengeluaranId);
                $stmt->bindparam(":namaDtlPngl", $namaDtlPngl);
                $stmt->bindparam(":jmlDtlPngl", $jmlDtlPngl);
                $stmt->bindparam(":tglDtlPngl", $tglDtlPngl);
                $stmt->execute();
                return true;
            }else{
                return false;
            }

        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }


    public function currentBalance($userId,$periode){

        $date_object = new DateTime($periode);
        $periode = $date_object->format('Y-m-t');

        $stmt = $this->db->prepare("SELECT SUM(nominalPghs) uang FROM penghasilan
                                              WHERE 
                                              userId=:id AND 
                                              flag='0' AND 
                                              MONTH(tglPghs)=MONTH(:periode) AND
                                              YEAR(tglPghs)=YEAR(:periode)");
        $stmt->bindParam(":id",$userId);
        $stmt->bindParam(":periode",$periode);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

//        $stmt2 = $this->db->prepare("SELECT SUM(jmlDtlPngl) spent
//FROM komppengeluaran,detailpengeluaran,pengeluaran
//WHERE komppengeluaran.userId=:id
//	AND MONTH(komppengeluaran.tglKomp)=MONTH(:periode)
//	AND YEAR(komppengeluaran.tglKomp)=YEAR(:periode)
//    AND komppengeluaran.kompId = pengeluaran.kompId
//    AND pengeluaran.pengeluaranId = detailpengeluaran.pengeluaranId
//    AND detailpengeluaran.flag='0'");
//        $stmt2->bindParam(":id",$userId);
//        $stmt2->bindParam(":periode",$periode);
//        $stmt2->execute();
//        $row2=$stmt2->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT SUM(Realisasi) Total_Realisasi FROM(
                                    SELECT SUM(jmlDtlPngl) AS Realisasi
                                    FROM komppengeluaran,pengeluaran,detailpengeluaran
                                    WHERE userId=:userId 
                                      AND komppengeluaran.kompId=pengeluaran.kompId 
                                      AND pengeluaran.pengeluaranId=detailpengeluaran.pengeluaranId 
                                      AND detailpengeluaran.flag='0' 
                                      AND komppengeluaran.flag='0' 
                                      AND MONTH(tglKomp)= MONTH(:periodebulan) 
                                      AND YEAR(tglKomp)= YEAR(:periodetahun)
                                    UNION
                                    SELECT SUM(jmlCicilan) AS Realisasi
                                    FROM komppengeluaran,pengeluaran,cicilan
                                    WHERE komppengeluaran.userId=:userId 
                                      AND komppengeluaran.kompId=pengeluaran.kompId 
                                      AND komppengeluaran.kompId = cicilan.kompId 
                                      AND cicilan.flag='0' 
                                      AND komppengeluaran.flag='0' 
                                      AND tglSelesai >= :periode 
                                      AND tglMulai <= :periode
                                    ) t1");
        $stmt->bindparam(":userId",$userId);
        $stmt->bindparam(":periodebulan",$periode);
        $stmt->bindparam(":periodetahun",$periode);
        $stmt->bindparam(":periode",$periode);
        $stmt->execute();
        $tot_peng = $stmt->fetch(PDO::FETCH_ASSOC);


        $result = $row['uang'] - $tot_peng['Total_Realisasi'];
        return $result;
    }
    public function getID($id){
        $stmt = $this->db->prepare("SELECT * FROM komppengeluaran WHERE kompId=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function getAnggaranID($id){
        $stmt = $this->db->prepare("SELECT * FROM pengeluaran , komppengeluaran 
                                              WHERE komppengeluaran.kompId=:id AND pengeluaran.kompId=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function getanggaraneditID($id){
        $stmt = $this->db->prepare("SELECT * FROM pengeluaran , komppengeluaran 
                                              WHERE komppengeluaran.kompId=pengeluaran.kompId AND 
                                              pengeluaran.pengeluaranId=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }



    public function getdetailID($id){
        $stmt = $this->db->prepare("SELECT * FROM pengeluaran , komppengeluaran 
                                              WHERE komppengeluaran.kompId=pengeluaran.kompId AND 
                                              pengeluaran.pengeluaranId=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0) {
            return $editRow;
        }else{
            return false;
        }
    }

    public function getdetaileditID($id){
        $stmt = $this->db->prepare("SELECT * FROM pengeluaran , komppengeluaran , detailpengeluaran 
                                      WHERE komppengeluaran.kompId=pengeluaran.kompId AND 
                                      pengeluaran.pengeluaranId=detailpengeluaran.pengeluaranId AND 
                                      detailpengeluaran.detailPnglId=:id");

        $stmt->bindParam(":id",$id);
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0) {
            return $editRow;
        }else{
            return false;
        }
    }


    public function update($userId,$id,$namaKomp,$tipePngl,$tglKomp,$persenKomp){
        try{
            if ($tipePngl == "true") {
                $tipe = "cicilan";
            } else {
                $tipe = "detil";
            }

            if($this->cekPersenEdit($userId,$tglKomp,$persenKomp,$id)){


                $stmt = $this->db->prepare("UPDATE komppengeluaran SET namaKomp=:namaKomp,
        persenKomp=:persenKomp,tipePngl=:tipePngl,tglKomp=:tglKomp
        WHERE kompId=:id ");
                $stmt->bindparam(":namaKomp", $namaKomp);
                $stmt->bindparam(":persenKomp", $persenKomp);
                $stmt->bindparam(":tipePngl", $tipe);
                $stmt->bindparam(":tglKomp", $tglKomp);
                $stmt->bindparam(":id", $id);
                $stmt->execute();

                return true;
            }else{
                return false;
            }

        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function updateanggaran($id,$anggaranPngl){
        try{
            $stmt=$this->db->prepare("UPDATE pengeluaran SET anggaranPngl=:anggaranPngl
        WHERE pengeluaranId=:id ");
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


    public function updatedetail($userId,$id,$namaDetailPngl,$jmlDtlPngl,$tglDtlPngl){
        try{
            $getPenghasilan = $this->db->prepare("SELECT SUM(nominalPghs) total FROM penghasilan WHERE flag='0' AND userId = :userId AND MONTH(tglPghs)=MONTH(CURRENT_DATE()) AND flag='0'");
            $getPenghasilan->bindparam(":userId",$userId);
            $getPenghasilan->execute();
            $currentPenghasilan = $getPenghasilan->fetch(PDO::FETCH_ASSOC);
            if (($currentPenghasilan['total']-(($this->cekDtlPnglEdit($userId,$id,$tglDtlPngl))+$jmlDtlPngl))>=0) {

                $stmt = $this->db->prepare("UPDATE detailpengeluaran SET namaDtlPngl=:namaDtlPngl,
        jmlDtlPngl=:jmlDtlPngl,tglDtlPngl=:tglDtlPngl
        WHERE detailPnglId=:id ");
                $stmt->bindparam(":namaDtlPngl", $namaDetailPngl);
                $stmt->bindparam(":jmlDtlPngl", $jmlDtlPngl);
                $stmt->bindparam(":tglDtlPngl", $tglDtlPngl);
                $stmt->bindparam(":id", $id);
                $stmt->execute();

                return true;
            }else{
                return false;
            }

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

            $stmt = $this->db->prepare("SELECT * FROM pengeluaran , komppengeluaran , detailpengeluaran 
                                      WHERE komppengeluaran.kompId=:id AND
                                       pengeluaran.kompId=:id AND
                                      pengeluaran.pengeluaranId=detailpengeluaran.pengeluaranId;");
            $stmt->bindParam(":id",$id);
            $stmt->execute(array(":id"=>$id));

            if($stmt->rowCount()>0) {
                $dodelete=false;
            }else{
                $dodelete=true;
            }

            if($dodelete){
                $stmt=$this->db->prepare("UPDATE komppengeluaran SET flag=:flag
        WHERE kompId=:id ");
                $stmt->bindparam(":flag",$flag);
                $stmt->bindparam(":id",$id);
                $stmt->execute();

                $stmt=$this->db->prepare("UPDATE pengeluaran SET flag=:flag
        WHERE kompId=:id ");
                $stmt->bindparam(":flag",$flag);
                $stmt->bindparam(":id",$id);
                $stmt->execute();

                return true;
            }else{
                return false;
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function deletedetail($id)
    {
//        $flag = '1';
        try{
            $stmt=$this->db->prepare("UPDATE detailpengeluaran SET flag='1'
        WHERE detailPnglId=:id ");
//            $stmt->bindparam(":flag",$flag);
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


    public function dataview($periode,$userId)
    {

        $stmt = $this->db->prepare("SELECT komppengeluaran.kompId,namaKomp,persenKomp,tipePngl,anggaranPngl Anggaran FROM komppengeluaran,pengeluaran
WHERE userId='".$userId."'
    AND komppengeluaran.kompId=pengeluaran.kompId
    AND komppengeluaran.flag='0'
    AND MONTH(komppengeluaran.tglKomp) = MONTH('".$periode."')
AND YEAR(komppengeluaran.tglKomp) = YEAR('".$periode."')
GROUP BY kompId
UNION
SELECT komppengeluaran.kompId,namaKomp,persenKomp,tipePngl,anggaranPngl Anggaran
FROM komppengeluaran,pengeluaran,cicilan
WHERE komppengeluaran.userId='".$userId."'
    AND komppengeluaran.kompId=pengeluaran.kompId
    AND komppengeluaran.kompId = cicilan.kompId
    AND cicilan.flag='0'
    AND komppengeluaran.flag='0'
    AND tglSelesai >='".$periode."'
    AND tglMulai <='".$periode."'
GROUP BY kompId");
        $stmt->bindparam(":periode",$periode);
        $stmt->bindparam(":userId",$userId);
        $stmt->execute();



        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {

                ?>

                <?php
                extract($this->getID($row['kompId']));


                if($tipePngl=="detil"){
                    $link="pengeluaran";
                    $linkanggaran="anggaran";
                }else
                {
                    $link="cicilan";
                    $linkanggaran="cicilan";
                }


                $getPenghasilan = $this->db->prepare("SELECT SUM(nominalPghs) total FROM penghasilan WHERE flag='0' AND userId = :userId AND MONTH(tglPghs)=MONTH(CURRENT_DATE())");
                $getPenghasilan->bindparam(":userId",$userId);
                $getPenghasilan->execute();
                $currentPenghasilan = $getPenghasilan->fetch(PDO::FETCH_ASSOC);

                $anggaran = ($row['persenKomp']/100 * $currentPenghasilan['total']);

                extract($this->getAnggaranID($row['kompId']));

                if($anggaranPngl>$anggaran){
                    $panelclr="danger";
                }else{
                    $panelclr="primary";
                }

                ?>

                <div class="grid col-md-3" style=" padding: 10px 5px 0px 0px;">
                    <div class="panel panel-<?php print $panelclr;?>">
                        <div class="panel-heading col-md-12">
                            <!--                            <div class="row">-->
                            <div class="col-md-8">
                                <?php print(strtoupper($row['namaKomp'])); ?>
                            </div>
                            <div class="col-md-4" style="text-align: right;">

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
                                <a href="view-<?php print $linkanggaran ?>.php?kom_id=<?php print($row['kompId']); ?>" class="btn btn-success btn-xs">Atur Anggaran</a>&nbsp;
                                <a href="edit-pengeluaran.php?edit_id=<?php print($row['kompId']); ?>" class="btn btn-warning btn-xs">Ubah</a>&nbsp;
                                <a href="delete-pengeluaran.php?delete_id=<?php print($row['kompId']); ?>" class="btn btn-danger btn-xs">Hapus</a>

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

    public function dataanggaranview($query)
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
                                <a href="view-anggaran.php?kom_id=<?php print($row['kompId']); ?>" class="btn btn-success btn-xs">Atur Anggaran</a>&nbsp;
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

    public function datadetailanggaranview($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $counter = 0;

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {

                $counter++;
                ?>

                <tr>
                    <td><?php print $counter;?></td>
                    <td><?php print(strtoupper($row['namaDtlPngl'])); ?></td>
                    <td><?php $tgl = new DateTime($row['tglDtlPngl']); print date_format($tgl,"d F Y");?></td>
                    <td align="right"><?php
                        echo "Rp &nbsp". number_format($row['jmlDtlPngl'],2,',','.');
                        ?></td>
                    <td align="center"><a href="edit-detail.php?edit_id=<?php print($row['detailPnglId']); ?>"><i class="glyphicon glyphicon-edit"></i></a>
                    </td>
                    <td align="center"><a href="delete-detail.php?delete_id=<?php print($row['detailPnglId']); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a></td>
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
