<?php 
    session_start();
    require_once('connect_db.php') ?>
<?php
    if( !isset($_SESSION['password'])){
        echo "You have to log in first <br> <h3><a href='login.html'>返回</a></h3>";
        header('location: elogin.html');
    }


    $m_id = $_SESSION['machine_id'];
    
    $gashapon_sql = mysqli_query($conn, "SELECT * FROM gashapon WHERE machine_id= '$m_id'");
?>

<html>
<head>
	<title>線上扭蛋機</title>
		<meta http-equiv="Content-Type" content="text/css; charset=utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2 align="center">扭蛋種類</h2>

    <table width="500" border="1" bgcolor="#fff" align="center">
        <div align='center'><form action="ehome.php"><input type="submit" value="返回首頁"></form></div>
        <tr>
            <th>扭蛋ID</th>
            <th>扭蛋名字</th>
            <th>圖片</th>
            <th>數量</th>
            <th>編輯</th>
        </tr>
        <?php 
            while($row = mysqli_fetch_row($gashapon_sql)){ 
                echo "<tr><th>".$row[0]."</th>"; // gashapon id
                echo "<th>".$row[1]."</th>"; // name
                echo "<th style='background-image:url($row[2])' width='200px' height='200px'></th>"; // pic
                echo "<th>".$row[3]."</th> "; // amount
                
                echo "<th><form action='' method='post'><button name='delete_id' type='submit' value='$row[0]'>刪除</button></form></th></tr>";
            }
        ?>
        
    </table>
    <div align='center'>
        <form action='' method='post'>
            <button type='submit' name='add_id'>新增扭蛋</button>
        </form>
       
    </div>

    <?php 
        if(isset($_POST['add_id']) ){
            echo "<form action='' method='post'><table width='500' align='center'>";
            echo "<tr><th>扭蛋名字</th><td><input type='text' name='g_name'></td></tr>";
            echo "<tr><th>扭蛋圖片(打網址)</th><td><input type='text' name='g_pic'></td></tr>";
            echo "<tr><th>扭蛋數量</th><td><input type='text' name='g_amount'></td></tr>";
            echo "</table><div align='center'><input type='submit' name='add_to_sql' value='新增'></div></form>";
        } else{
            //echo "資料不完全，請重新整理";
        }
?>
</body>
</html>


<?php
// run deleted gaashapon
if(isset($_POST['delete_id']) ){
    $delete_id = $_POST['delete_id'];
    //echo $delete_id;
    $sql = "DELETE FROM gashapon WHERE gashapon_id = '$delete_id'";
    if ($conn->query($sql) === TRUE){
        $sql = "UPDATE machine SET amount = amount - 1 WHERE machine_id = '$m_id'";
        $conn->query($sql);
        header('Refresh:2');
    }
    else
        echo "資料不完全";
} 
// add new gashapon
if (isset($_POST['add_to_sql']) && isset($_POST['g_name']) &&  isset($_POST['g_pic']) && isset($_POST['g_amount'])){

    $name = $_POST['g_name'];
    $pic = $_POST['g_pic'];
    $amount = $_POST['g_amount'];

    $insert_sql = "INSERT INTO gashapon(name, picture, amount, machine_id) VALUES('$name', '$pic', '$amount', '$m_id')";
    if ($conn->query($insert_sql) === TRUE){

        $update_sql = "UPDATE machine SET amount = amount + 1 WHERE machine_id = '$m_id'";
        $conn->query($update_sql);
        header('Refresh:2');
    }else{
        echo "<div align='center'> <h2><font color='antiquewith'>ERROR!!請在試一次!</font></h2> </div>";
    }
   
//     //header("Refresh:2");
}
else if ( isset($_POST['add_to_sql']) && (!isset($_POST['g_name']) ||  !isset($_POST['g_pic']) || !isset($_POST['g_amount'])) )
    echo "<div align='center'> <h2><font color='antiquewith'>請填寫全部空格再送出!!</font></h2> </div>";
?>