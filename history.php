<?php

session_start();
require_once("connect_db.php");

//找到玩家id 
$id = $_SESSION['player_id'];
?>

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
            </tr>

<?php

    //找到已寄出的訂單（歷史訂單）
    $search_sql = mysqli_query($conn, "SELECT O.orderform_id, G.gashapon_id, G.name FROM player as P JOIN orderform as O JOIN gashapon as G WHERE P.player_id = '$id' AND P.player_id = O.player_id AND O.gashapon_id = G.gashapon_id AND send = 1");
    

       // 找到對應玩家id的訂單
       while ($row = mysqli_fetch_array($search_sql)) {
        // print_r( $row);
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[2] . "</td>";
        echo "</tr>";
    }

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

?>

    </table>

</body>

</html>