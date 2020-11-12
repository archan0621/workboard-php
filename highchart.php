<?php
ini_set('display_errors', '0');
$connect = mysqli_connect('localhost','root','root','board') or die("connect fail");

@$sdate = $_GET['sdate'] != null ? $_GET['sdate'] : "2020-01-01";
@$edate = $_GET['edate'] != null ? $_GET['edate'] : "2020-01-01";

@$stime = $_GET['stime'] != null ? $_GET['stime'] : "00:00";
@$etime = $_GET['etime'] != null ? $_GET['etime'] : "00:01";

$infoArray = array();

$query = "select * from info order by meter_seq";

$result = $connect->query($query);

while ($row = mysqli_fetch_array($result)) {
  $data = array(
    'seq' => $row['meter_seq'],
    'id' => $row['meter_id'],
    'name' => $row['location_name'],
    'data' => array()
  );
  
  array_push($infoArray, $data);
}

$query = "select * from sdata where STR_TO_DATE('".$sdate." ".$stime.":00','%Y-%m-%d %H:%i:%s') <= time and time <= STR_TO_DATE('".$edate." ".$etime.":00','%Y-%m-%d %H:%i:%s') order by time";

$result = $connect->query($query);

while($row = mysqli_fetch_array($result)){
  $sdata = array(
    'energy' => $row['ENERGY'],
    'wh' => $row['WH'],
    'pt' => $row['PT'],
    'degree' => $row['DEGREE']
  );

  for ($i = 0; $i < count($infoArray) ; $i++) {
    if ($infoArray[$i]['seq'] == $row['METER_SEQ']) {
      array_push($infoArray[$i]['data'], $sdata);
    }
  }
}
// echo "<pre>";
// print_r($infoArray);
// echo "</pre>";

?>  
<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>highcharts</title>
      <style>
          @import url(//fonts.googleapis.com/earlyaccess/nanumpenscript.css);

          .highcharts-figure, .highcharts-data-table table {
            min-width: 36px;
            margin: 1em auto;
          }       
          .highcharts-figure {
            display: flex;
            flex-direction: row;
          }
          .highcharts-figure > div {
            flex: 1;
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
          body{
            height:969px;
          }
      </style>
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<script>
function getExcel() {
      const startDate = document.getElementById("sdate").value;
      const startTime = document.getElementById("stime").value;
      const endDate = document.getElementById("edate").value;
      const endTime = document.getElementById("etime").value;

      var popup = window.open("/exportchart.php?sdate=" + startDate + "&stime="+startTime+"&edate="+endDate+"&etime="+endTime);
  }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<form action="highchart.php" method="get">
  <input type="date" class="btn btn-dark" name="sdate" id="sdate" value="<?=$sdate?>">
  <input type="time" class="btn btn-dark" name="stime" id="stime" value="<?=$stime?>"> ~
  <input type="date" class="btn btn-dark" name="edate" id="edate" value="<?=$edate?>">
  <input type="time" class="btn btn-dark" name="etime" id="etime" value="<?=$etime?>">
  <button type="submit" class="btn btn-success">입력</button>
  <button class="btn btn-danger" onclick="getExcel();" class="btn btn-danger">추출</button>
            </form>
<figure class="highcharts-figure">
    <div id="container1" style="height: 300px"></div>
    <div id="container2" style="height: 300px"></div>
    <div id="container3" style="height: 300px"></div>
    <div id="container4" style="height: 300px"></div>
    <div id="container5" style="height: 300px"></div>
    </figure>
<figure class="highcharts-figure">
    <div id="container6" style="height: 300px"></div>
    <div id="container7" style="height: 300px"></div>
    <div id="container8" style="height: 300px"></div>
    <div id="container9" style="height: 300px"></div>
    <div id="container10" style="height: 300px"></div>
</figure>
<figure class="highcharts-figure">
    <div id="container11" style="height: 300px"></div>
    <div id="container12" style="height: 300px"></div>
    <div id="container13" style="height: 300px"></div>
    <div id="container14" style="height: 300px"></div>
    <div id="container15" style="height: 300px"></div>
</figure>
<figure class="highcharts-figure">
    <div id="container16" style="height: 300px"></div>
    <div id="container17" style="height: 300px"></div>
    <div id="container18" style="height: 300px"></div>
    <div id="container19" style="height: 300px"></div>
    <div id="container20" style="height: 300px"></div>
</figure>
<figure class="highcharts-figure">
    <div id="container21" style="height: 300px"></div>
    <div id="container22" style="height: 300px"></div>
    <div id="container23" style="height: 300px"></div>
    <div id="container24" style="height: 300px"></div>
    <div id="container25" style="height: 300px"></div>
</figure>
<figure class="highcharts-figure">
    <div id="container26" style="height: 300px"></div>
    <div id="container27" style="height: 300px"></div>
    <div id="container28" style="height: 300px"></div>
    <div id="container29" style="height: 300px"></div>
    <div id="container30" style="height: 300px"></div>
</figure>
<!-- <figure class="highcharts-figure"> for fixing highchart error #13 not neccesary
    <div id="container31" style="height: 300px"></div>
    <div id="container32" style="height: 300px"></div>
    <div id="container33" style="height: 300px"></div>
</figure> -->
</body>
</html>
<script type="text/javascript">
<?php

for($j = 1; $j < count($infoArray) ; $j++){


      $energy = [];
      $wh = [];
      $pt = [];
      $degree = [];
      for($k = 1 ; $k < count($infoArray[$j]['data']) ; $k++) {
        $logData = $infoArray[$j]['data'][$k];
        
        array_push($energy, $logData['energy']);
        array_push($wh,$logData['wh']);
        array_push($pt, $logData['pt']);
        array_push($degree, $logData['degree']);
      }


      $energyTemp = sizeof($energy) > 0 ? join($energy, ',') : ""; 
      $whTemp = sizeof($wh) > 0 ? join($wh,',') : "";
      $ptTemp = sizeof($pt) > 0 ? join($pt ,',') : "";
      $degreeTemp = sizeof($degree) > 0 ? join($degree ,',') : "";
      ?>
      

      let chart<?php echo $j?> = Highcharts.chart('container<?php echo $j?>', {
      title: {
        text: '<?php echo $infoArray[$j]['name']?>'
      },

      yAxis: {
        title: {
          text: 'Numbers',
          height: 15,
          endOnTick: false,
        }
      },

      xAxis: {
        accessibility: {
          rangeDescription: ''
        }
      },

      legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
      },

      plotOptions: {
        series: {
          label: {
            connectorAllowed: false
          },
          pointStart: 0
        }
      },

      series: [{
        name: '에너지',
        data: [<?php echo $energyTemp?>]
      }, {
        name: '와트시',
        data: [<?php echo $whTemp ?>]
      }, {
        name: '변성 비율',
        data: [<?php echo $ptTemp?>]
      }, {
        name: '값',
        data: [<?php echo $degreeTemp?>]
      }],

      responsive: {
        rules: [{
          condition: {
            maxWidth: 500
          },
          chartOptions: {
            legend: {
              layout: 'horizontal',
              align: 'left',
              verticalAlign: 'bottom'
            }
          }
        }]
      }
      });
      <?php
      }
      ?>
</script>