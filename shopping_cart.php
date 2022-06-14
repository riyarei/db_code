<?php 
    session_start();
    require_once("connect_db.php");

    //找到玩家id 
    $id = $_SESSION['player_id'];
?>

<html>

<head>
    <title>線上扭蛋機-購物車</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    
    <h1 align="center">玩家購物車</h1>

    <div align='center'><form action="phome.php"><input type="submit" value="返回首頁"></form></div>
    <form action="" method="post">
        <table width="500" border="1" bgcolor="#cccccc" align="center">
            <tr>
                <th>訂單編號</th>
                <th>商品名稱</th>
                <th>寄出</th>
            </tr>

           <?php
                // 找到對應玩家id的訂單
                $search_sql = mysqli_query($conn, "SELECT O.orderform_id, G.gashapon_id, G.name FROM player as P JOIN orderform as O JOIN gashapon as G WHERE P.player_id = '$id' AND P.player_id = O.player_id AND O.gashapon_id = G.gashapon_id AND send = 0");
            
                if(!$search_sql)
                    printf("error : %s\n", mysqli_error($conn));
                //用迴圈印出表格
                while ($row = mysqli_fetch_array($search_sql, MYSQLI_BOTH)) 
                {
                    // print_r( $row);
                    echo "<tr>";
                    echo "<td>" . $row[0] . "</td>";
                    //echo "<td>" . $row[1] . "</td>";
                    echo "<td>" . $row[2] . "</td>";
                    echo "<td> <input type='checkbox' name='checkbox[]' value='$row[0]' id='checkbox_0' /> </td>";
                    echo "</tr>";
            
                }
           
           ?>

           
        </table>
        <div align='center'><input type='submit' name = 'send_id' value='寄送' /></div>
    </form>
    <?php
				
        if(isset($_POST['send_id'])){
            // 找到對應玩家id的訂單
            $check=$_POST['checkbox'];
            foreach($check as $value){
                $result = mysqli_query($conn, "UPDATE orderform SET send = 1 WHERE orderform_id = '$value'");
                //echo $value."<br>";
                $conn->query($result);
            }

            header("Refresh:2");
        }


        mysqli_free_result( $search_sql );

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
    ?>



    

</body>

</html>