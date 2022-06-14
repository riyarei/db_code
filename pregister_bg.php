<?php
require_once('connect_db.php');

if ( isset($_POST['password']) && isset($_POST['account']) && isset($_POST['address']) ) {
	
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
	echo "資料不完全";
}
				
?>

