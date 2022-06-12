<?php
session_start();

// ******** update your personal settings ******** 
$servername = "localhost"; // your_servername
$username = "root"; // your_username
$password = "12345678"; // your_password
$dbname = "ddl_pj"; // your_dbname

// Connecting to and selecting a MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

/*if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
}
*/
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ( isset($_POST['player_id']) && isset($_POST['password']) ) {
	$p_id = $_POST['player_id'];
	$psw = $_POST['password'];

       // search if account and password exist
	$search_sql = mysqli_query($conn, "SELECT * FROM player WHERE player_id = '$p_id' AND password = '$psw'");	

	if (mysqli_num_rows($search_sql) == 1) { // 若有這組帳號&密碼，進入轉蛋主頁面
		$_SESSION['player_id'] = $p_id;
        $_SESSION['password'] = $psw;
       
        header("Location: phome.php");
 
	} else { // 若不存在，可能是帳號 或 密碼打錯 OR 不存在這組帳密 
		echo "<div align='center'> <h2><font color='antiquewith'>帳號或密碼不存在!!請重試 或 註冊!!</font></h2> <h3><a href='plogin.html'>返回</a></h3> </div>";
	}

}else{
	echo "資料不完全";
}
				
?>

