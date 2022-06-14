<?php 
session_start();

// ******** update your personal settings ******** 
$servername = "localhost"; // your_servername
$username = "root"; // your_username
$password = "12341234"; // your_password
$dbname = "db_project"; // your_dbname


// Connecting to and selecting a MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>

<html>

<head>
    <title>線上扭蛋機-購物車</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1 align="center">玩家購物車</h1>
    <form action="send.php" method="post">
        <table width="500" border="1" bgcolor="#cccccc" align="center">
            <tr>
                <th>訂單編號</th>
                <th>商品名稱</th>
				<th>扭蛋機名稱</th>
				<th>金額</th>
                <th>寄出</th>
            </tr>

            <!-- <tr>
                <td>apple</td>
                <td> <input type="checkbox" name="checkbox[]" id="checkbox_0"> </td>
            </tr> -->

<?php

//找到玩家id 但我不知道要怎麼傳玩家id進來
$id = $_SESSION['player_id'];


    // 找到對應玩家id的訂單
	/* $search_sql = mysqli_query($conn, "SELECT orderform_id, gashapon_id FROM player JOIN orderform USING(player_id) WHERE player_id = '$id' AND send = 0"); */
	$search_sql = mysqli_query($conn, "select `orderform_id`, `gashapon_id`, `gashapon`.`name`, `machine`.`name`, `machine`.`price`, `machine_id` from (((`player` join `orderform` using(player_id)) join `gashapon` using(gashapon_id)) join `machine` using(`machine_id`)) where `player_id` = '$id' and send = 0 order by `orderform_id` "); 
    //用迴圈印出表格
    while ($row = mysqli_fetch_array($search_sql, MYSQLI_NUM)) 
    {
        // print_r( $row);
        echo "<tr>";
		/*
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        */
		echo "<td>" . $row[0] . "</td>";
		echo "<td>" . $row[2] . "(id : " . $row[1] . ")</td>";
		echo "<td>" . $row[3] . "(id : " . $row[5] . ")</td>";
		echo "<td>" . $row[4] . "</td>";
		echo "<td> <input type='checkbox' name='checkbox[]' id='checkbox_0' /> </td>";
        echo "<tr>";

    }

				

    mysqli_free_result( $search_sql );

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>

</table>
    </form>
	<div align="center">
	<form action="phome.php"><input type="submit" value="返回"></form>
	</div>
</body>

</html>