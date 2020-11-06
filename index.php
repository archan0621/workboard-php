<!DOCTYPE html>
 
<html>
<head>
        <meta charset = 'utf-8'>
        <link rel="stylesheet" href="page.css">
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="bootstrap.min.css">
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>
<style>
        table{
                border-top: 1px solid #444444;
                border-collapse: collapse;
        }
        tr{
                border-bottom: 1px solid #444444;
                padding: 10px;
        }
        td{
                border-bottom: 1px solid #efefef;
                padding: 10px;
        }
        table .even{
                background: #efefef;
        }
        .text{
                text-align:center;
                padding-top:20px;
                color:#000000
        }
        .text:hover{
                text-decoration: underline;
        }
        a:link {color : #57A0EE; text-decoration:none;}
        a:hover { text-decoration : underline;}
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
<body>
<?php
                $connect = mysqli_connect('localhost', 'root', 'root', 'board') or die ("connect fail");
                $query ="select * from data order by number desc";
                $result = $connect->query($query);
                $total = mysqli_num_rows($result);
                
                session_start();
                
                if(isset($_SESSION['userid'])) {
                        echo $_SESSION['userid'];?>님이(가) 접속중입니다.
                        
                        
                        <br/>

                        <button onclick="location.href='./logout.php'" style="margin-left:-5px; vertical-align=top;">로그아웃</button>
                        <button><font style="cursor: hand"onClick="location.href='./write.php'">글 쓰기</font></button>
                        <button><font style="cursor: hand"onClick="location.href='./export.php'">추출하기</font></button>
                <?php   
                while ($row = mysqli_fetch_array($result)) {
                       $number[] = $row['number'];
                       $value[] = $row['value'];
                       $degree[] = $row['degree'];
                       $conver[] = $row['conver'];
                }
                ?>
        <?php
                }
                else {
        ?>              <button onclick="location.href='./login.php'">로그인</button>
                        <br />
        <?php   }
        ?>
        <?php
                if(isset($_GET["page"]))
                        $page = $_GET["page"];
                else
                        $page = 1;
        ?>

<?php
        if(isset($_GET['page'])) {

                $page = $_GET['page'];

        } else {

                $page = 1;

        }
        $sql = 'select count(*) as cnt from data order by number desc';

        $result = $connect->query($sql);

        $row = $result->fetch_assoc();

        $allPost = $row['cnt']; 

        $onePage = 5; 

        $allPage = ceil($allPost / $onePage); 

        if($page < 1 || ($allPage && $page > $allPage)) {
            ?>
                    <script>
                        alert("존재하지 않는 페이지입니다.");
                        history.back();
                </script>
        <?php

                exit;

        }
        $oneSection = 10; 

        $currentSection = ceil($page / $oneSection);

        $allSection = ceil($allPage / $oneSection); 

        $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); 

        if($currentSection == $allSection) {
                     $lastPage = $allPage; 
        } else {
                $lastPage = $currentSection * $oneSection;
        }
        $prevPage = (($currentSection - 1) * $oneSection); 

        $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); 

        $paging = '<ul>'; 

        if($page != 1) { 

                $paging .= '<li class="page page_start"><a href="./index.php?page=1">처음</a></li>';

        }
        
        if($currentSection != 1) { 

                $paging .= '<li class="page page_prev"><a href="./index.php?page=' . $prevPage . '">이전</a></li>';

        }

        for($i = $firstPage; $i <= $lastPage; $i++) {
                if($i == $page) {
                        $paging .= '<li class="page current">' . $i . '</li>';
                } else {
                        $paging .= '<li class="page"><a href="./index.php?page=' . $i . '">' . $i . '</a></li>';
                }
        }
       
        if($currentSection != $allSection) { 
                $paging .= '<li class="page page_next"><a href="./index.php?page=' . $nextPage . '">다음</a></li>';
        }

       
        if($page != $allPage) { 
                $paging .= '<li class="page page_end"><a href="./index.php?page=' . $allPage . '">끝</a></li>';
        }
        $paging .= '</ul>';

       

        $currentLimit = ($onePage * $page) - $onePage; 

        $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; 

        $sql = 'select * from ( select @rownum:=@rownum+1  no, 	A.* from data A, (select @rownum := 0) r where  1=1 order by number desc ) list' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지

        $result = $connect->query($sql);
        ?>
        <h1>php+xampp+mysql</h1>

        <table align = center>
        <thead align = "center">
        <figure class="highcharts-figure">
        <div id="container"></div>
        <p class="highcharts-description">
          </p>
        </figure>
      
        <h2 align=center>게시판</h2>
        <tr>
        <td width ="80" align="center">고유번호</td> <!--고유번호-->
        <td width = "50" align="center">계량기 번호</td>
        <td width = "500" align = "center">데이터 입력시간</td>
        <td width = "100" align = "center">적산치</td>
        <td width = "200" align = "center">이전 적산치 차수</td>
        <td width = "50" align = "center">시간당 적산 환산값</td>
        </tr>

        </thead>
			
		</tfoot>
        <tbody>
     
        <?php   
                
                while($rows = mysqli_fetch_assoc($result)){
                        if($total%2==0){
        ?>                      <tr class = "even">
                        <?php   }
                        else{
        ?>                      <tr>
                        <?php } ?>
                        
                <td width = "50" align = "center"><?php echo $rows['no']?></td> <!--고유 번호-->
                <td width = "500" align = "center">
                <a href="./view.php?number=<?php echo $row['numbers']?>"></a>
                <?php echo $rows['number']?></td>
                  <td width = "100" align = "center"><?php echo $rows['time']?></td>
                <td width = "200" align = "center"><?php echo $rows['value']?></td>
                <td width = "50" align = "center"><?php echo $rows['degree']?></td>
                <td width="50" align="center"><?php echo $rows['conver']?></td>
                </tr>                
        <?php
                $total--;
                }
        ?>
        </tbody>
        </table>
        <div class = text>
        <div class="paging">

<?php echo $paging ?>

</div>
        
        </div>
        <script type="text/javascript">

Highcharts.chart('container', {

title: {
  text: '계량기 그래프'
},

yAxis: {
  title: {
    text: 'Number of LogData'
  }
},

xAxis: {
  accessibility: {
    rangeDescription: 'Range: 2020 to 2020'
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
</body>
</html>