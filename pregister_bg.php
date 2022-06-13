<?php

// ******** update your personal settings ******** 
$servername = "localhost"; // your_servername
$username = "root"; // your_username
$password = "12345678"; // your_password
$dbname = "ddl_pj"; // your_dbname

// Connecting to and selecting a MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ( isset($_POST['password']) && isset($_POST['account']) && isset($_POST['address']) ) {
	
	// reset auto increment
	$sql = mysqli_query($conn, "ALTER TABLE `player` AUTO_INCREMENT = 1");
	$conn->query($sql);

	$account = $_POST['account'];
	$psw = $_POST['password'];
	$address = $_POST['address'];

	$insert_sql = mysqli_query($conn, "INSERT INTO player(password, account, money, address) VALUES('$psw', '$account', 200, '$address'");	// 在 player 表新增資料 
	
	if ($conn->query($insert_sql) !== TRUE) {
		echo "註冊成功!!<br> <a href='plogin.html'>返回登入</a>";
	} else {
		echo "<div align='center'> <h2><font color='antiquewith'>註冊失敗!!</font></h2> <h3><a href='pregister.php'>返回</a></h3> </div>";
	}

}else{
	echo "資料不完全";
}
				
?>

