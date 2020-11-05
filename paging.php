<!DOCTYPE html>
 
<html>
<head>
        <meta charset = 'utf-8'>
        <link rel="stylesheet" href="page.css">
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="bootstrap.min.css">
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
                        <button onclick="location.href='./logout.php'" style="margin-left:200px; vertical-align=top;">로그아웃</button>
                        
                        <br/>
                        <button><font style="cursor: hand"onClick="location.href='./write.php'">글 쓰기</font></button>
                
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

        $allPost = $row['cnt']; //전체 게시글의 수

        $onePage = 15; // 한 페이지에 보여줄 게시글의 수.

        $allPage = ceil($allPost / $onePage); //전체 페이지의 수

        if($page < 1 || ($allPage && $page > $allPage)) {
            ?>
                    <script>
                        alert("존재하지 않는 페이지입니다.");
                        history.back();
                </script>
        <?php

                exit;

        }
        $oneSection = 10; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)

        $currentSection = ceil($page / $oneSection); //현재 섹션

        $allSection = ceil($allPage / $oneSection); //전체 섹션의 수

        $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

        if($currentSection == $allSection) {
                     $lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
        } else {
                $lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
        }
        $prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.

        $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

        $paging = '<ul>'; // 페이징을 저장할 변수

        //첫 페이지가 아니라면 처음 버튼을 생성

        if($page != 1) { 

                $paging .= '<li class="page page_start"><a href="./paging.php?page=1">처음</a></li>';

        }
        //첫 섹션이 아니라면 이전 버튼을 생성
        if($currentSection != 1) { 

                $paging .= '<li class="page page_prev"><a href="./paging.php?page=' . $prevPage . '">이전</a></li>';

        }

        for($i = $firstPage; $i <= $lastPage; $i++) {
                if($i == $page) {
                        $paging .= '<li class="page current">' . $i . '</li>';
                } else {
                        $paging .= '<li class="page"><a href="./paging.php?page=' . $i . '">' . $i . '</a></li>';
                }
        }
        //마지막 섹션이 아니라면 다음 버튼을 생성
        if($currentSection != $allSection) { 
                $paging .= '<li class="page page_next"><a href="./paging.php?page=' . $nextPage . '">다음</a></li>';
        }

        //마지막 페이지가 아니라면 끝 버튼을 생
        if($page != $allPage) { 
                $paging .= '<li class="page page_end"><a href="./paging.php?page=' . $allPage . '">끝</a></li>';
        }
        $paging .= '</ul>';

        /* 페이징 끝 */

        $currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지

        $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문

        $sql = 'select * from ( select @rownum:=@rownum+1  no, 	A.* from data A, (select @rownum := 0) r where  1=1 order by number desc ) list' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지

        // SELECT * FROM ( SELECT @rownum:=@rownum+1  no, 	A.* FROM data A, (SELECT @ROWNUM := 0) R WHERE  1=1 order by number desc ) list limit 1, 10
        // SELECT * FROM ( SELECT @rownum:=@rownum+1  no, A.* FROM data  A, (SELECT @ROWNUM := 0) R WHERE 1=1) list WHERE rnum >= 1 AND rnum <=15 

        $result = $connect->query($sql);
        ?>
        <h1>php+xampp+mysql</h1>
        <h2 align=center>게시판</h2>
        <table align = center>
        <thead align = "center">
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
                
                while($rows = mysqli_fetch_assoc($result)){ //DB에 저장된 데이터 수 (열 기준)
                        if($total%2==0){
        ?>                      <tr class = "even">
                        <?php   }
                        else{
        ?>                      <tr>
                        <?php } ?>
                        
                <td width = "50" align = "center"><?php echo $rows['no']?></td> <!--고유 번호-->
                <td width = "500" align = "center">
                <!--<a href = "view.php?number=<//?php echo $rows['numbers']?>">-->
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
</body>
</html>