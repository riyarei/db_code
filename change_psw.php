<?php
session_start(); 
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

$login_e_id = $_SESSION['enterprise_id']; 
//echo $login_e_id."<br>";

if ( isset($_POST['new_psw'])  ) {

	//$old_psw = $_POST['old_psw'];
	$new_psw = $_POST['new_psw'];
    //echo $new_psw."<br>";

    $sql = "UPDATE enterprise SET password='$new_psw' WHERE enterprise_id = '$login_e_id'";
	$change_psw_sql = mysqli_query($conn, $sql);
	//echo $change_psw_sql."<br>";

    $result = $conn->query($change_psw_sql);
    echo $result."<br>";
	if ( ($result ) === TRUE) {
        echo "<div align='center'> <h2><font color='antiquewith'>舊密碼!!</font></h2> <h3><a href='change_psw.html'>返回</a></h3> </div>";
		
	} else {
		echo "<div align='center'> <h2><font color='antiquewith'>註冊成功!!</font></h2> <h3><a href='ehome.php'>返回首頁</a></h3> </div>";
	}

}else{
	echo "資料不完全";
}
				
?>

