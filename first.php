<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   </head>
   <style>
      .title{
            text-align: center;
            margin-top: -55px;
            margin-left: 220px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            width: 1700px;
      }
      .header{
        width: 100px;
      }
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
        .login{margin-left:1680px; margin-top:-500px;}
   </style>
<body>
    <header style="margin-bottom: 0px; vertical-align: top;">
		<div class="header">
			<a href="index.php"><img src="img/hodi.png" style="margin-top: 5px;"></a>
      <?php
                $connect = mysqli_connect('localhost', 'root', 'root', 'board') or die ("connect fail");
                $query ="select * from board order by number desc";
                $result = $connect->query($query);
                $total = mysqli_num_rows($result);
 
                session_start();
 
                if(isset($_SESSION['userid'])) {
                        echo $_SESSION['userid'];?>님 안녕하세요
                        <br/>
                <button onclick="location.href='./logout.php'">로그아웃</button>
        <?php
                }
                else {
        ?>              <button" onclick="location.href='./login.php'">로그인</button>
                        <br />
        <?php   }
        ?>
        <!-- </div> -->
			<h1 class="title">Library</h1>
		</div>
	</header>
  <hr>
</body>
</html>