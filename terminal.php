<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script>
        var join = confirm( '현재 게시판 DB와 연결되있지 않습니다 작성하신 글이 반영되지 않을 수도 있습니다.' );
        if(confirm == 1){
                session_start();
        }else{  
                location.replace("<?php echo $URL?>");
        }

   </script> 
</body>
</html>