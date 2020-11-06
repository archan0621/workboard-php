<?php
$connect = mysqli_connect('localhost','root','root','board') or die("connect fail");
$query = "select * from data order by number desc ";
$result = $connect->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>highcharts</title>
       <style>
              .highcharts-figure, .highcharts-data-table table {
                     min-width: 360px; 
                     max-width: 800px;
                     margin: 1em auto;
              }             

              .highcharts-data-table table {
              	font-family: Verdana, sans-serif;
              	border-collapse: collapse;
              	border: 1px solid #EBEBEB;
              	margin: 10px auto;
              	text-align: center;
              	width: 100%;
              	max-width: 500px;
              }
              .highcharts-data-table caption {
                  padding: 1em 0;
                  font-size: 1.2em;
                  color: #555;
              }
              .highcharts-data-table th {
              	font-weight: 600;
                  padding: 0.5em;
              }
              .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
                  padding: 0.5em;
              }
              .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
                  background: #f8f8f8;
              }
              .highcharts-data-table tr:hover {
                  background: #f1f7ff;
              }

       </style>
</head>
<body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
    </p>
</figure>



</body>
</html>
<?php
while ($row = mysqli_fetch_array($result)) {
       $number[] = $row['number'];
       $value[] = $row['value'];
       $degree[] = $row['degree'];
       $conver[] = $row['conver'];
}
?>
<script type="text/javascript">

Highcharts.chart('container', {

title: {
  text: '계량기 그래프'
},

yAxis: {
  title: {
    text: 'Number of Employees'
  }
},

xAxis: {
  accessibility: {
    rangeDescription: 'Range: 2010 to 2017'
  }
},

legend: {
  layout: 'vertical',
  align: 'right',
  verticalAlign: 'middle'
},

plotOptions: {
  series: {
    label: {
      connectorAllowed: false
    },
    pointStart: 2010
  }
},

series: [{
  name: '계량기 번호',
  data: [null]
}, {
  name: '적산치',
  data: [<?php echo join($value, ',') ?>]
}, {
  name: '이전 적산치 차수',
  data: [null]
}, {
  name: '적산치 환산값',
  data: [null]
}],

responsive: {
  rules: [{
    condition: {
      maxWidth: 500
    },
    chartOptions: {
      legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
      }
    }
  }]
}

});

</script>