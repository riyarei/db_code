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
    <div align='center'>

    <?php
        
        $gc_sql = "SELECT `machine`.`name`, `price`, `machine`.`picture`, `machine`.`amount`, sum(`gashapon`.`amount`) from `machine` join `gashapon` using(machine_id)
        WHERE `machine_id` = $m_id
        group by `machine_id`
        having sum(`gashapon`.`amount`)>0/* 扭蛋個數要大於0才會列出 */";
        
        $result = mysqli_query($conn,$gc_sql);
        $gashapon_count = mysqli_num_rows($result);
        mysqli_free_result($result);

        $player_money_sql = "SELECT `money` FROM `player` WHERE `player_id`=$login_p_id;";
        $result = mysqli_query($conn,$player_money_sql);
        $pm = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        $pay_money_sql = "SELECT `price` FROM `machine` WHERE `machine_id`=$m_id;";
        $result = mysqli_query($conn,$pay_money_sql);
        $mm = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        if( $pm["money"]<$mm["price"]  ){
            $message = '您的餘額不足，請儲值後繼續';
            echo "<script type='text/javascript'>alert('$message');</script>";
            //exit();
        }

        else if( $gashapon_count>0  ) {
            echo "<h3>恭喜您! 你獲得 :</h3> <br>";
            $g_sql = "SELECT `machine`.`name`, `price`, `machine`.`picture`, `machine`.`amount`, sum(`gashapon`.`amount`) from `machine` join `gashapon` using(machine_id)
                group by `machine_id`
                having sum(`gashapon`.`amount`)>0/* 扭蛋個數要大於0才會列出 */
                order by `price` desc;";
            $player_before_money = "SELECT `money`
            from `player`
            where `player_id` = ' $login_p_id'";

            $sql = "SELECT * FROM gashapon WHERE machine_id= '$m_id' and `amount`>0 ORDER BY rand() LIMIT 1 ";
            $gashapon_sql = mysqli_query($conn, $sql);

            //if($conn->query($gashapon_sql) === FALSE){
               // echo "<div align='center'> <h2><font color='antiquewith'>ERROR!!此扭蛋機應故無法使用，請等待工作人員處理!!</font></h2> <h3><a href='phome.php'>返回上頁</a></h3> </div>";
               // exit();
            //}
            
            //echo $m_id."<br>";

         
            //$row = mysqli_fetch_array($gashapon_sql);
            while($row = mysqli_fetch_row($gashapon_sql)){
                echo "<img src='$row[2]' alt='$row[2]' style='width:300px; height:300px;'><br> ";
                echo "扭蛋名稱 : ".$row[1]."<br>請去購物車查看商品 ";
                
                $get_gashapon_id = $row[0];
                //$m_id = $row[0];
                
                
            }

            $minus_amount = "update `gashapon` set `amount` = `amount` - 1 where `gashapon_id` = '$get_gashapon_id'";  
            $conn->query($minus_amount);
            
            $minus_p_money = "update `player` set `money` = (select case when `money` >= `price` then `money` - `price` else `money` end from `machine` where `machine_id` = '$m_id') where `player_id` = '$login_p_id'";
            $conn->query($minus_p_money);

            $insert_to_order = "INSERT INTO `orderform` (`send`, `gashapon_id`, `player_id`) VALUES(0, '$get_gashapon_id', '$login_p_id')";
            $conn->query($insert_to_order);

            $sql_2 = "SELECT price FROM machine WHERE machine_id= '$m_id'";
            $sql_2 = mysqli_query($conn, $sql_2);
            $m_row = mysqli_fetch_array($sql_2, MYSQLI_NUM);

            //echo "<br><br>".$m_row[0]."<br>";

            $e_sql = "UPDATE enterprise JOIN machine USING(enterprise_id) SET money = money + '$m_row[0]' WHERE machine_id= '$m_id' ";
            $conn->query($e_sql);
        }
        else {
            $message = '已經沒有扭蛋了，請換一個機台~';
            echo "<script type='text/javascript'>alert('$message');</script>";
        }


    ?>
    <form action="phome.php"><input type="submit" class="go-back-button" value="返回"></form></div>
            
   

   
</body>
</html>

