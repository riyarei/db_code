<?php
require_once('connect_db.php'); 

if ( isset($_POST['password']) && isset($_POST['account']) ) {

	// reset auto increment
	$sql = mysqli_query($conn, "ALTER TABLE `enterprise` AUTO_INCREMENT = 1");
	$conn->query($sql);

	$psw = $_POST['password'];
	$account = $_POST['account'];

	$insert_sql = mysqli_query($conn, "INSERT INTO enterprise(password, account, money) VALUES('$psw', '$account', 0)");	// 在 enterprise 表新增資料 
	
	if ($conn->query($insert_sql) !== TRUE) {
		echo "註冊成功!!<br> <a href='elogin.html'>返回登入</a>";
	} else {
		echo "<div align='center'> <h2><font color='antiquewith'>註冊失敗!!</font></h2> <h3><a href='eregister.php'>返回</a></h3> </div>";
	}
//}
}else{
	echo "資料不完全";
}
				
?>

