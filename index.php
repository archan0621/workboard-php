<!DOCTYPE html>
 
<html>
<head>
        <meta charset = 'utf-8'>
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
                <button onclick="location.href='./logout.php'" style="margin-left:200px; vertical-align=top;">로그아웃</button>
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
        <h1>php+xampp+mysql</h1>
        <h2 align=center>게시판</h2>
        <table align = center>
        <thead align = "center">
        <tr>
        <td width ="80" align="center">고유번호</td>
        <td width = "50" align="center">계량기 번호</td>
        <td width = "500" align = "center">데이터 입력시간</td>
        <td width = "100" align = "center">적산치</td>
        <td width = "200" align = "center">이전 적산치 차수</td>
        <td width = "50" align = "center">시간당 적산 환산값</td>
        </tr>

        </thead>
        <?php 
		if(isset($_GET["nowPage"])){
			$nowPage=$_GET["nowPage"];
			$nowBlock=$_GET["nowBlock"];
		}else{
			$nowPage=1;
			$nowBlock=1;
                }
                $queryAll="select * from data";
                $rs=mysqli_query($connect,$queryAll);
                $totPage=ceil(mysqli_num_rows($rs)/10);
		$totBlock=ceil($totPage/10);
		
		$startDataRow=($nowPage-1)*10;
		$queryLimit="select * from data order by number desc limit $startDataRow,10";
		$rsLimit=mysqli_query($connect,$queryLimit);


        ?>
        <caption style="text-align:left;caption-side:bottom"><br>
				<?php 
					$nowBlock=ceil($nowPage/10); //페이지번호가 10을 넘어가기 전까지 이 블록은 항상 1임

					//prev 버튼
					if($nowBlock>1){
						$prevBlock=$nowBlock-1;
						$prevStartPage=($prevBlock-1)*10+1;
						print "<a href='paging.php?nowPage=$prevStartPage&nowBlock=$prevBlock'>prev</a>";
						echo "&nbsp;&nbsp;";
					}
					//페이지번호 출력
					$startPage=($nowBlock-1)*10+1;
					$endPage=$startPage+9;
					for($i=$startPage;$i<=$endPage;$i++){
						if($nowPage==$i) $col="red";
						else $col="#cccccc";
						
						if($i>$totPage){break;}//페이지 더 없으면 넘어강
						echo " <a href='paging.php?nowPage=$i&nowBlock=$nowBlock'>
						<font color=$col>".$i."</font></a> ";
					}
					//next 버튼
					if($nowBlock<$totBlock){
						echo "&nbsp;&nbsp;";
						$nextBlock=$nowBlock+1;
						$nextStartPage=($nextBlock-1)*10+1;
						print " <a href='paging.php?nowPage=$nextStartPage&nowBlock=$nextBlock'>next</a>";
					}
				?>
				<br>
				<br>
				<button type="button" onclick="location.href='notice_write.php'">새글쓰기</button>
			</caption>
			
		</tfoot>
        <tbody>
        <?php   
                
                while($rows = mysqli_fetch_assoc($result)){ //DB에 저장된 데이터 수 (열 기준)
                     //while($row=mysqli_fetch_array($rsLimit)){
                        if($total%2==0){
        ?>                      <tr class = "even">
                        <?php   }
                        else{
        ?>                      <tr>
                        <?php } ?>
                <td width = "50" align = "center"><?php echo $total?></td>
                <td width = "500" align = "center">
                <a href = "view.php?number=<?php echo $rows['numbers']?>">
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
        <button><font style="cursor: hand"onClick="location.href='./write.php'">writing</font></butoon>
        </div>
 
 
 
 
 
 
</body>
</html>