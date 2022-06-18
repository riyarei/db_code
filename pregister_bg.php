<?php
require_once('connect_db.php');

if(strlen($_POST['password'])>15) {
	$message = '密碼長度請限制在15個字以內!'; 
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "註冊失敗!!<br> <a href='pregister.php'>返回註冊</a>";
}
else if(strlen($_POST['account'])>18) {
	$message = '不合法的帳戶!'; 
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "註冊失敗!!<br> <a href='pregister.php'>返回註冊</a>";
}
else if ( strlen($_POST['password'])>0 && strlen($_POST['account'])>0 && strlen($_POST['address'])>0 ) {
	
	// reset auto increment
	$sql = mysqli_query($conn, "ALTER TABLE `player` AUTO_INCREMENT = 1");
	$conn->query($sql);

	$account = $_POST['account'];
	$psw = $_POST['password'];
	$addr = $_POST['address'];

	$insert_sql = mysqli_query($conn, "INSERT INTO player(password, account, money, address) VALUES('$psw', '$account', 200, '$addr')");	// 在 player 表新增資料 
	
	if ($conn->query($insert_sql) !== TRUE) {
		echo "<div align='center'> <h2><font color='black'>註冊成功!!<br></h2> <h3><a href='plogin.html'>返回登入</a></h3></div>";
	} else {
		echo "<div align='center'> <h2><font color='antiquewith'>註冊失敗!!</font></h2> <h3><a href='pregister.php'>返回</a></h3> </div>";
	}

}else{
	$message = '資料不完全'; 
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "註冊失敗!!<br> <a href='pregister.php'>返回註冊</a>";
}
				
?>

