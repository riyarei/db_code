<?php

session_start();
require_once("connect_db.php");

//找到玩家id 
$id = $_SESSION['player_id'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>線上扭蛋機-歷史紀錄</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="style.css">
</head>

<body>
   
    <h1 align="center">歷史紀錄</h1>
    <div align='center'><form action="phome.php"><input type="submit" value="返回首頁"></form></div>

    <h3 align="center">已寄送</h3>
    <table width="500" border="1" bgcolor="#cccccc" align="center">
        <tr>
            <th>訂單編號</th>
            <th>商品名稱</th>
            <th>扭蛋機名稱</th>
            <th>金額</th>
            
        </tr>

    <?php
        //找到已寄出的訂單（歷史訂單）
        /* $search_sql = mysqli_query($conn, "SELECT orderform_id, gashapon_id FROM player JOIN orderform USING(player_id) WHERE player_id = '$id' AND send = 1"); */
        $search_sql = mysqli_query($conn, "select `orderform_id`, `gashapon_id`, `gashapon`.`name`, `machine`.`name`, `machine`.`price`, `machine_id` from (((`player` join `orderform` using(player_id)) join `gashapon` using(gashapon_id)) join `machine` using(`machine_id`)) where `player_id` = '$id' and send = 1 order by `orderform_id` desc"); 

        // 找到對應玩家id的訂單
        while ($row = mysqli_fetch_array($search_sql)) {
            echo "<tr>";
            echo "<td>" . $row[0] . "</td>";
            echo "<td>" . $row[2] . "(id : " . $row[1] . ")</td>";
            echo "<td>" . $row[3] . "(id : " . $row[5] . ")</td>";
            echo "<td>" . $row[4] . "</td>";
            echo "</tr>";
        }

    ?>

    </table>

</body>

</html>
