<?php
session_start();
require_once('connect_db.php');

if ( isset($_POST['player_id']) && isset($_POST['password']) && isset($_POST['login'])) {
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

}else if ( isset($_POST['register']) ){
	header("Location: pregister.php");
}
else{
	echo "資料不完全";
}
				
?>

