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

$login_p_id = $_SESSION['player_id'];


if ( isset($_POST['new_psw'])  ) {
	$get_new_addr = '';
	$get_save_money = '';
    //echo $login_p_id."<br>";
    
	//$old_psw = $_POST['old_psw'];
	$new_psw = $_POST['new_psw'];
    //echo $new_psw."<br>";

    $sql_1 = "UPDATE player SET password='$new_psw' WHERE player_id = '$login_p_id'";
	$change_psw_sql = mysqli_query($conn, $sql_1);
	echo $change_psw_sql."<br>";

    $result1 = $conn->query($change_psw_sql);
    echo $result1."<br>";
	if ( ($result1 ) === TRUE) {
        echo "<div align='center'> <h2><font color='antiquewith'>舊密碼!!</font></h2> <h3><a href='change_psw_p.html'>返回</a></h3> </div>";
		
	} else {
		echo "<div align='center'> <h2><font color='antiquewith'>密碼更改成功!!</font></h2> <h3><a href='phome.php'>返回首頁</a></h3> </div>";
	}
	exit();
}

if ( isset($_POST['new_addr'])  ) {
	$get_new_psw = '';
	$get_save_money = '';
	//$old_psw = $_POST['old_psw'];
	$new_addr = $_POST['new_addr'];
    //echo $new_psw."<br>";

    $sql_2 = "UPDATE player SET address='$new_addr' WHERE player_id = '$login_p_id'";
	$change_addr_sql = mysqli_query($conn, $sql_2);
	//echo $change_psw_sql."<br>";

    $result2 = $conn->query($change_addr_sql);
    echo $result2."<br>";
	if ( ($result2 ) === TRUE) {
        echo "<div align='center'> <h2><font color='antiquewith'>!!</font></h2> <h3><a href='change_psw_p.html'>返回</a></h3> </div>";
		
	} else {
		echo "<div align='center'> <h2><font color='antiquewith'>地址更改成功!!</font></h2> <h3><a href='phome.php'>返回首頁</a></h3> </div>";
	}
	exit();
}

if ( isset($_POST['save_money'])  ) {
	$get_new_psw = '';
	$get_new_addr = '';
	//$old_psw = $_POST['old_psw'];
	$save_money = $_POST['save_money'];
    //echo $new_psw."<br>";

    $sql_3 = "UPDATE player SET money = money + '$save_money' WHERE player_id = '$login_p_id'";
	$save_money_sql = mysqli_query($conn, $sql_3);
	//echo $change_psw_sql."<br>";

    $result3 = $conn->query($save_money_sql);
    echo $result3."<br>";
	if ( ($result3 ) === TRUE) {
        echo "<div align='center'> <h2><font color='antiquewith'>舊密碼!!</font></h2> <h3><a href='change_psw_p.html'>返回</a></h3> </div>";
		
	} else {
		echo "<div align='center'> <h2><font color='antiquewith'>已儲值!!</font></h2> <h3><a href='phome.php'>返回首頁</a></h3> </div>";
	}
	exit();
}else{
	echo "資料不完全";
}


?>

