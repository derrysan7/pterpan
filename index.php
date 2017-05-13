<?php
include_once "classes/Penghasilan.php";
include_once "views/header.php";
$penghasilan = new Penghasilan();
include_once "classes/class.crud.pengeluaran.php";
$pengeluaran = new Pengeluaran();
include_once 'classes/class.crud.berita.php';
$berita = new crud();

if(isset($_GET['selected_month']) == "")
    {
        $date_now = date("Y-m-t");
    }
    elseif(empty($_GET['selected_month'])) 
    { 
      $date_now = date("Y-m-t");
    }
    elseif(isset($_GET['selected_month']))
    {
        $date_object = new DateTime("20-".$_GET['selected_month']);       
        $date_now = $date_object->format("Y-m-t");
    }

    $month_now = substr($date_now,5,2);
    $year_now = substr($date_now,0,4);
?>
<link rel="stylesheet" href="style/css/homeberita.css" type="text/css"/>
    
    <div class="clearfix"></div>

    <div class="container">
    <h2>Dashboard</h2>
    </div>

    <div class="clearfix"></div><br />

    <div class="container">
        <script type="text/javascript">
            $(document).ready(function() {               

                $.getJSON('data_penghasilan.php?selected_month=06-2017', function(data) {
                    var seriesOptions = [];
                    var seriesLabel = [];
                    var arrayLength = data.length;
                    for (var i = 0; i < arrayLength; i++){
                        seriesLabel[i] = data[i][0];
                    }
                    for (var i = 0; i < arrayLength; i++){
                        seriesOptions[i] = data[i][1];
                    }
                    var options = {
                        chart: {
                            renderTo: 'container',
                            type: 'column'
                        },
                        title: {
                            text: 'Penghasilan Bulan Ini',
                        },
                        xAxis: {
                            categories: seriesLabel
                        },
                        yAxis: {
                            title: {
                            text: 'Nominal (Rp)'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: false
                            }
                        },
                        credits: {
					    	enabled: false
					  	},
                        series: [{
                                name: 'Nominal',
                                data: seriesOptions
                            }]
                    };
                    var chart = new Highcharts.Chart(options);
                });

            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {               

                $.getJSON('data_pengeluaran.php?selected_month=06-2017', function(data) {
                    var seriesOptions = [];
                    var seriesOptions2 = [];
                    var seriesLabel = [];
                    var arrayLength = data.length;
                    for (var i = 0; i < arrayLength; i++){
                        seriesLabel[i] = data[i][1];
                    }
                    for (var i = 0; i < arrayLength; i++){
                        seriesOptions[i] = data[i][3];
                    }
                    for (var i = 0; i < arrayLength; i++){
                        seriesOptions2[i] = data[i][4];
                    }
                    var options = {
                        chart: {
                            renderTo: 'container_peng_rp',
                            type: 'column'
                        },
                        title: {
                            text: 'Pengeluaran Bulan Ini (Rp)',
                        },
                        xAxis: {
                            categories: seriesLabel
                        },
                        yAxis: {
                            title: {
                            text: 'Nominal (Rp)'
                            }
                        },
                        legend: {
                            enabled: true
                        },
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: false
                            }
                        },
                        credits: {
					    	enabled: false
					  	},
                        series: [{
                                name: 'Anggaran',
                                data: seriesOptions
                            	},
                            	{
                                name: 'Realisasi',
                                data: seriesOptions2
                            	}]
                    };
                    var chart = new Highcharts.Chart(options);
                });

            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {               

                $.getJSON('data_pengeluaran_persen.php?selected_month=06-2017', function(data) {
                    var seriesOptions = [];
                    var seriesOptions2 = [];
                    var seriesLabel = [];
                    var arrayLength = data.length;
                    for (var i = 0; i < arrayLength; i++){
                        seriesLabel[i] = data[i][1];
                    }
                    for (var i = 0; i < arrayLength; i++){
                        seriesOptions[i] = data[i][3];
                    }
                    for (var i = 0; i < arrayLength; i++){
                        seriesOptions2[i] = data[i][4];
                    }
                    var options = {
                        chart: {
                            renderTo: 'container_peng_persen',
                            type: 'column'
                        },
                        title: {
                            text: 'Pengeluaran Bulan Ini (%)',
                        },
                        xAxis: {
                            categories: seriesLabel
                        },
                        yAxis: {
                            title: {
                            text: 'Persen (%) dari Total Penghasilan'
                            }
                        },
                        legend: {
                            enabled: true
                        },
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: false
                            }
                        },
                        credits: {
					    	enabled: false
					  	},
                        series: [{
                                name: 'Anggaran',
                                data: seriesOptions
                            	},
                            	{
                                name: 'Realisasi',
                                data: seriesOptions2
                            	}]
                    };
                    var chart = new Highcharts.Chart(options);
                });

            });
        </script>

        <div class="row">
	        <div class="col-md-6">
		        <div class="panel panel-default">
					<div class="panel-heading">Pendapatan May 2017</div>
					<div class="panel-body" id="container" style="width:100%; height:400px;"></div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Pengeluaran May 2017(%)</div>
					<div class="panel-body" id="container_peng_persen" style="width:100%; height:400px;"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Pengeluaran May 2017(Rp)</div>
					<div class="panel-body" id="container_peng_rp" style="width:100%; height:400px;"></div>
				</div>
			</div>
		</div>
		<div class="row">
	        <div class="col-md-5">
		        <div class="panel panel-default">
		        <div class="panel-heading">Laporan Keuangan May 2017</div>

		        	<div style="padding:1em">
			        	<h3><strong>Penghasilan</strong></h3>
			        	<?php
			        	$laporan_pghs = $penghasilan->lap_penghasilan($_SESSION['user_session'],$month_now,$year_now);
			        	$total_pghs = 0;
			        	for ($i = 0; $i < count($laporan_pghs); $i++) {
						    echo '<h5 style="padding-left:4em">'.$laporan_pghs[$i][0].'  =  '.number_format($laporan_pghs[$i][1],0,',','.').'<h5>';
						    $total_pghs = $total_pghs + $laporan_pghs[$i][1];
						}
			        	?>
			        	<h4 style="padding-left:2em"><strong>Total Penghasilan = <?php echo number_format($total_pghs,0,',','.'); ?></strong></h4>
			        	
			        	<h3><strong>Pengeluaran</strong></h3>
			        	<?php
			        	$laporan = $pengeluaran->lap_komp_pengeluaran($_SESSION['user_session'],$date_now,$month_now,$year_now);
			        	$total_peng = 0;
			        	for ($i = 0; $i < count($laporan); $i++) {
						    echo '<h4 style="padding-left:2em"><strong>'.$laporan[$i][1].'</strong><h4>';
						    $laporan_det = $pengeluaran->lap_detail_pengeluaran($_SESSION['user_session'],$laporan[$i][0],$date_now,$month_now,$year_now);

						    for ($d = 0; $d < count($laporan_det); $d++) {
						    	echo '<h5 style="padding-left:4em">'.$laporan_det[$d][2].'  =  '.number_format($laporan_det[$d][3],0,',','.').'<h5>';
						    	$total_peng = $total_peng + $laporan_det[$d][3];
							}
						}
			        	?>
			        	<h4 style="padding-left:2em"><strong>Total Pengeluaran = <?php echo number_format($total_peng,0,',','.'); ?></strong></h4>	        	
			        	
			        	<!-- Sisa Saldo -->
			        	<?php 
			        	$saldo = $total_pghs - $total_peng; 
			        	$saldo_formatted = number_format($saldo,0,',','.'); 
			        	if($saldo_formatted < 0){
			        		echo '<h3 style="color:red"><strong>Sisa Saldo = Rp. '.$saldo_formatted.'<h3>';
			        	}else{
			        		echo '<h3><strong>Sisa Saldo = Rp '.$saldo_formatted.'<h3>';
			        	}
			        	?>
		        	</div>

				</div>
			</div>
			<div class="col-md-7">
					<?php
			              $query = "SELECT * FROM berita ORDER BY tanggaldib DESC";
			              $berita->dataviewhomeberita($query);
			          ?>

			</div>
		</div>
        
    </div>

<?php include_once 'views/footer.php'; ?>