<?php  
    session_start(); 
    require_once('connect_db.php') ;
?>
<?php 
    $login_p_id = $_SESSION['player_id']; 
    $account_sql = mysqli_query($conn, "SELECT * FROM player WHERE player_id= '$login_p_id' ");
?>
<!DOCTYPE html>
<html>
<head>
	<title>線上扭蛋機</title>
		<meta http-equiv="Content-Type" content="text/css; charset=utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h3>查詢帳戶</h3>
    <?php
        while($row = mysqli_fetch_row($account_sql)){
            echo "玩家帳戶 : ".$row[2]."<br>";
            echo "玩家寄送地址 : ".$row[4]."<br>";
            echo "現有金額 : ".$row[3];
        }
    ?>
    <form action="phome.php"><input type="submit" value="返回"></form>
            
   

   
</body>
</html>
