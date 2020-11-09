<?php
header("Content-type: text/json");

$x = time() * 1000;
$y = rand(0, 100);

$ret = array($x, $y);
echo json_encode($ret);
?>

<html>
    <head>
        <title>Highcharts Live Test</title>
    </head>
    <body>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="js/highcharts.js"></script>
        <script>
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
           
            var chart;
            function requestData() {
                $.ajax({
                    // url: 'live-server-data.php',
                    url: 'http://localhost/test/live-server-data.php',
                    success: function (point) {
                        var series = chart.series[0],
                            shift = series.data.length > 20;
                       
                        console.log(point);
                       
                        var timestamp = point[0];
                        var date = new Date(timestamp);
                        console.log(date);
                           
                        chart.series[0].addPoint(point, true, shift);
                       
                        setTimeout(requestData, 1000);
                    },
                    cache: false
                });
            }
           
            $(function () {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        defaultSeriesType: 'spline',
                        events: {
                            load: requestData
                        }
                    },
                    title: {
                        text: 'Live random data'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 150,
                        maxZoom: 20 * 1000
                    },
                    yAxis: {
                        minPadding: 0.2,
                        maxPadding: 0.2,
                        title: {
                            text: 'Value',
                            margin: 80
                        }
                    },
                    series: [{
                        name: 'Random data',
                        data: []
                    }]
                });
            });
        </script>
        <div id="container" style="width: 100%; height: 400px">
        </div>
    </body>
</html>