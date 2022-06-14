<?php
session_start(); 
require_once('connect_db.php');

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

