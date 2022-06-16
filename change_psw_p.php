<?php
session_start(); 
require_once('connect_db.php');

$login_p_id = $_SESSION['player_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>線上扭蛋機</title>
		<meta http-equiv="Content-Type" content="text/css; charset=utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h3>更改密碼、地址、儲值金幣</h3>

    <form action="change_psw_p.php" method="post">
        <div>
            新密碼<input type="text" name="new_psw" />
            <input type="submit" name='submit_1' value="更改密碼">
        </div>
    </form>
    <form action="change_psw_p.php" method="post">
        <div>
            新地址<input type="text" name="new_addr" />
            <input type="submit" name='submit_2' value="更改地址">
        </div>
    </form>
    <form action="change_psw_p.php" method="post">
        <div>
            儲值金幣<input type="text" name="save_money" />
            <input type="submit" name='submit_3'  value="儲值">
        </div>
    </form>
   
    <form action="phome.php"><input type="submit"  value="返回"></form>
   
</body>
</html>
<?php

if(isset($_POST['submit_1'])){
	if ( isset($_POST['new_psw']) && !empty($_POST['new_psw'])) {
		//echo $login_p_id."<br>";
		
		//$old_psw = $_POST['old_psw'];
		$new_psw = $_POST['new_psw'];
		//echo $new_psw."<br>";
	
		$sql_1 = "UPDATE player SET password='$new_psw' WHERE player_id = '$login_p_id'";
		$change_psw_sql = mysqli_query($conn, $sql_1);
		//echo $change_psw_sql."<br>";
	
		$result1 = $conn->query($change_psw_sql);
		//echo $result1."<br>";
		if ( ($result1 ) === TRUE) {
			$message = '有錯誤，請重試!!';
        	echo "<script type='text/javascript'>alert('$message');</script>";
		} else {
			echo "<br><div > <h2><font color='antiquewith'>密碼更改成功!!</font></h2>  </div>";
		}
		exit();
	}else if(empty($_POST['new_psw'])){
		$message = '請填入新密碼後再送出!';
        echo "<script type='text/javascript'>alert('$message');</script>";
	}
}

else if (isset($_POST['submit_2'])){

	if ( isset($_POST['new_addr']) && !empty($_POST['new_addr']) ) {
		//$old_psw = $_POST['old_psw'];
		$new_addr = $_POST['new_addr'];
		//echo $new_psw."<br>";
	
		$sql_2 = "UPDATE player SET address='$new_addr' WHERE player_id = '$login_p_id'";
		$change_addr_sql = mysqli_query($conn, $sql_2);
		//echo $change_psw_sql."<br>";
	
		$result2 = $conn->query($change_addr_sql);
		//echo $result2."<br>";
		if ( ($result2 ) === TRUE) {
			$message = '有錯誤，請重試!!';
        	echo "<script type='text/javascript'>alert('$message');</script>";
			
		} else {
			echo "<br><div> <h2><font color='antiquewith'>地址更改成功!!</font></h2> </div>";
		}
		exit();
	}else if (empty($_POST['new_addr'])){
		$message = '請填入新地址後再送出!';
        echo "<script type='text/javascript'>alert('$message');</script>";
	}
}
else if (isset($_POST['submit_3'])){

	if ( isset($_POST['save_money']) && !empty($_POST['save_money'])  ) {
		//$old_psw = $_POST['old_psw'];
		$save_money = $_POST['save_money'];
		//echo $new_psw."<br>";
	
		$sql_3 = "UPDATE player SET money = money + '$save_money' WHERE player_id = '$login_p_id'";
		$save_money_sql = mysqli_query($conn, $sql_3);
		//echo $change_psw_sql."<br>";
	
		$result3 = $conn->query($save_money_sql);
		//echo $result3."<br>";
		if ( ($result3 ) === TRUE) {
			$message = '有錯誤，請重試!!';
        	echo "<script type='text/javascript'>alert('$message');</script>";
		} else {
			echo "<br><div > <h2><font color='antiquewith'>已儲值!!</font></h2>  </div>";
		}
		exit();
	}else{
		//echo "資料不完全";
		$message = '請填入儲值金額後再送出!';
        echo "<script type='text/javascript'>alert('$message');</script>";
	}
}




?>

