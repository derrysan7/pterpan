<?php
include_once "classes/Penghasilan.php";
include_once "views/header.php";
$penghasilan = new Penghasilan();
include_once "classes/class.crud.pengeluaran.php";
$pengeluaran = new Pengeluaran();
?>
    
    <div class="clearfix"></div>

    <div class="container">
    <h2>Dashboard</h2>
    </div>

    <div class="clearfix"></div><br />

    <div class="container">
        <script type="text/javascript">
            $(document).ready(function() {               

                $.getJSON('data_penghasilan.php', function(data) {
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

                $.getJSON('data_pengeluaran.php', function(data) {
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
                            renderTo: 'container2',
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

                $.getJSON('data_pengeluaran_persen.php', function(data) {
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
                            renderTo: 'container3',
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
					<div class="panel-heading">Pendapatan April 2017</div>
					<div class="panel-body" id="container" style="width:100%; height:400px;"></div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Pengeluaran April 2017(%)</div>
					<div class="panel-body" id="container3" style="width:100%; height:400px;"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Pengeluaran April 2017(Rp)</div>
					<div class="panel-body" id="container2" style="width:100%; height:400px;"></div>
				</div>
			</div>
		</div>
        
        <div id="container" style="width:60%; height:400px; margin-bottom:60px;"></div>
        <div id="container3" style="width:40%; height:400px; margin-bottom:60px;"></div>
        
    </div>

<?php include_once 'views/footer.php'; ?>