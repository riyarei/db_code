<?php
session_start(); 
require_once('connect_db.php');

$login_e_id = $_SESSION['enterprise_id']; 
//echo $login_e_id."<br>";
?>

<!DOCTYPE html>
<html>
<head>
	<title>線上扭蛋機</title>
		<meta http-equiv="Content-Type" content="text/css; charset=utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h3>更改密碼</h3>

    <form action="" method="post">
        <div>
            新密碼<input type="text" name="new_psw" />
            <input type="submit" name='submit' value="更改密碼">
        </div>
    </form>
   
    <form action="ehome.php"><input type="submit"  value="返回首頁"></form>
   
</body>
</html>

<?php
if(isset($_POST['submit'])){
	if(strlen($_POST['new_psw'])>15){
		$message = '密碼長度請限制在15個字以內!'; 
		 echo "<script type='text/javascript'>alert('$message');</script>";
	}
	else if ( isset($_POST['new_psw']) && !empty($_POST['new_psw']) ) {

		//$old_psw = $_POST['old_psw'];
		$new_psw = $_POST['new_psw'];
		//echo $new_psw."<br>";
	
		$sql = "UPDATE enterprise SET password='$new_psw' WHERE enterprise_id = '$login_e_id'";
		$change_psw_sql = mysqli_query($conn, $sql);
		//echo $change_psw_sql."<br>";
	
		$result = $conn->query($change_psw_sql);
		//echo $result."<br>";
		if ( ($result ) === TRUE) {
			$message = '有錯誤，請重試!!';
        	echo "<script type='text/javascript'>alert('$message');</script>";
			//echo "<div align='center'> <h2><font color='antiquewith'>!!</font></h2> </div>";
			
		} else {
			echo "<br><div> <h2><font color='antiquewith'>更改成功!</font></h2> </div>";
		}
	
	}else if(empty($_POST['new_psw'])){
		$message = '請填入新密碼後再送出!';
        	echo "<script type='text/javascript'>alert('$message');</script>";
	}
	else{
		echo "資料不完全";
	}

}

				
?>

