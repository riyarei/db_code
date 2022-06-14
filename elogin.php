<?php
session_start();

require_once("connect_db.php");

if ( isset($_POST['enterprise_id']) && isset($_POST['password']) && isset($_POST['login'])) {
	$e_id = $_POST['enterprise_id'];
	$psw = $_POST['password'];

       // search if account and password exist
	$search_sql = mysqli_query($conn, "SELECT * FROM enterprise WHERE enterprise_id = '$e_id' AND password = '$psw'");	

	if (mysqli_num_rows($search_sql) == 1) { // 若有這組帳號&密碼，進入轉蛋主頁面
		$_SESSION['enterprise_id'] = $e_id;
        $_SESSION['password'] = $psw;
       
        header("Location: ehome.php");
 
	} else { // 若不存在，可能是帳號 或 密碼打錯 OR 不存在這組帳密 
		echo "<div align='center'> <h2><font color='antiquewith'>帳號或密碼不存在!!請重試 或 註冊!!</font></h2> <h3><a href='elogin.html'>返回</a></h3> </div>";
	}

}else if ( isset($_POST['register']) ){
	header("Location: eregister.php");
}
else{
	echo "資料不完全";
}
				
?>

