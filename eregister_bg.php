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

if ( isset($_POST['password']) && isset($_POST['account']) ) {
	//$account = $_POST['account'];
	$psw = $_POST['password'];
	$account = $_POST['account'];

	$insert_sql = "INSERT INTO enterprise(password, account) VALUES('$psw', '$account')";	// 在 player 表新增資料 
	
	if ($conn->query($insert_sql) === TRUE) {
		echo "註冊成功!!<br> <a href='elogin.html'>返回登入</a>";
	} else {
		echo "<div align='center'> <h2><font color='antiquewith'>註冊失敗!!</font></h2> <h3><a href='eregister.php'>返回</a></h3> </div>";
	}

}else{
	echo "資料不完全";
}
				
?>

