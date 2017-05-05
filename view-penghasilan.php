<?php
include_once "classes/Penghasilan.php";
include_once "views/header.php";
$penghasilan = new Penghasilan();
?>
    
    <div class="clearfix"></div>

    <div class="container">
    <h2>Penghasilan</h2>
        <a href="add-penghasilan.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
    </div>

    <div class="clearfix"></div><br />

    <div class="container">
        <script type="text/javascript">
            $(document).ready(function() {               

                $.getJSON('data_penghasilan.php', function(data) {
                    var seriesOptions = [];
                    seriesOptions = data;
                    var seriesLabel = [];
                    var arrayLength = data.length;
                    for (var i = 0; i < arrayLength; i++){
                        seriesLabel[i] = "'"+data[i][0]+"'";
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
        <div id="container" style="width:100%; height:400px; margin-bottom:60px;"></div>
        <table class='table table-bordered table-responsive'>
            <tr>
                <th>#</th>
                <th>Sumber Penghasilan</th>
                <th>Tanggal Penghasilan</th>
                <th>Nominal Penghasilan</th>
                <th colspan="2" align="center">Actions</th>
            </tr>
            <?php
            $query = "SELECT * FROM penghasilan WHERE flag='0' AND userId='".$userId."'";
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

<?php include_once 'views/footer.php'; ?>