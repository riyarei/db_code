<?php  
    session_start(); 
    require_once('connect_db.php') ;
?>
<?php 
    $login_p_id = $_SESSION['player_id']; 
    $m_id = $_SESSION['machine_id']; 
    
?>

<html>
<head>
	<title>線上扭蛋機</title>
		<meta http-equiv="Content-Type" content="text/css; charset=utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h3>你獲得 : </h3>
    <?php
        $gashapon_sql = mysqli_query($conn, "SELECT * FROM gashapon WHERE machine_id= '$m_id' ORDER BY rand() LIMIT 1 ");
        echo $m_id."<br>";
        //$row = mysqli_fetch_array($gashapon_sql);
        while($row = mysqli_fetch_row($gashapon_sql)){
            echo "gash id : ".$row[0]."<br>";
            echo "現有金額 : ".$row[3]."<br>";
            echo "machine id : ".$row[4]."<br>";
        }
    ?>
    <form action="phome.php"><input type="submit" value="返回"></form>
            
   

   
</body>
</html>