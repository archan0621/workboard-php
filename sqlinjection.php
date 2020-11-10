<?php
$connect = mysqli_connect('localhost','root','root','inject');

?>

<form action="" method="get">
<table width="50%">
    <tr>
        <td>User</td>
        <td><input type="text" name="user"></td>
    </tr>
    <tr>
        <td>pw</td>
        <td><input type="text" name="password"></td>
    </tr>
</table>
    <input type="submit" value="OK" name="ok">
</form>

<?php
if($_POST['ok']){
    $user = $_POST['user'];
    $pass = $_POST['password'];     
    $query= ("select * from member where id = '$user' and pw = '$pass'");
    $result = $connect->query($query);
    if(mysqli_num_rows($result) == 0){       
        echo 'wrong:(';
    }else{
        echo 'flag';
    }
}
?>