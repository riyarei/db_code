<?php 
    session_start();
    ob_start();
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
    <h3 align="center">說明 : </h3>
    <h4 align="center">新增數量 : 按下之後請滑到頁面下方填寫 </h4>
    <table width="800" border="1" bgcolor="#fff" align="center">
        <div align='center'>
            <form action="ehome.php">
                <input type="submit" value="返回首頁">
            </form>
            <br>
            <form action='' method='post'>
                <button type='submit' name='add_id'>新增扭蛋</button>
            </form>
        </div>
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
                echo "<th><img src='$row[2]' alt='$row[2]' style='width:200px; height:200px;'></th>"; // pic
                echo "<th>".$row[3]."</th> "; // amount
                
                echo "<th><form action='' method='post'><button name='add_amount' type='submit' value='$row[0]'>新增數量</button><button name='delete_id' type='submit' value='$row[0]'>刪除</button></form></th></tr>";
            }
        ?>
        
    </table>

    <?php 
        if(!empty($_POST['add_id']) ){
            echo "<form action='' method='post'><table width='500' align='center'>";
            echo "<tr><th>扭蛋名字</th><td><input type='text' name='g_name'></td></tr>";
            echo "<tr><th>扭蛋圖片(打網址)</th><td><input type='text' name='g_pic'></td></tr>";
            echo "<tr><th>扭蛋數量</th><td><input type='text' name='g_amount'></td></tr>";
            echo "</table><div align='center'><input type='submit' name='add_to_sql' value='新增'></div></form>";
        } else{
            //echo "資料不完全，請重新整理";
        }
        if(!empty($_POST['add_amount']) ){
            $_SESSION['gashapon_id'] = $_POST['add_amount'];
            echo "<form action='' method='post'><table width='500' align='center'>";
            echo "<tr><th>增加數量</th><td><input type='text' name='new_amount'></td></tr>";
            echo "</table><div align='center'><input type='submit' name='add_amount_to_sql' value='新增數量'></div></form>";
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

    $check = "SELECT * FROM orderform JOIN gashapon USING(gashapon_id) 
    WHERE gashapon_id = '$delete_id' and send=0";

    $check_sql = mysqli_query($conn, $check);
    //echo "<br> ".$check." <br>";
    //printf("ERROR : %s\n", mysqli_num_rows($check_sql));
    if(mysqli_num_rows($check_sql) > 0){
        //echo "<br> yes <br>";
        $message = '有其他玩家尚未寄送這個扭蛋機裡的扭蛋，不能刪除';
        echo "<script type='text/javascript'>alert('$message');</script>";
        exit();
    }
    else{
       //echo "<br> no <br>";
        //echo $delete_id;
        $sql = "DELETE FROM gashapon WHERE gashapon_id = '$delete_id'";
        if ($conn->query($sql) === TRUE){
            $sql = "UPDATE machine SET amount = amount - 1 WHERE machine_id = '$m_id'";
            $conn->query($sql);
            header('Location: '.$_SERVER['REQUEST_URI']);
            ob_end_flush();
        }
        else
            echo "資料不完全";
        
    }
    
} 
// add new gashapon
if (isset($_POST['add_to_sql'])){

    if(empty($_POST['g_name'])) {
        $message = '請輸入新扭蛋名稱'; 
        echo "<script type='text/javascript'>alert('$message');</script>";
    }else if(empty($_POST['g_pic'])) {
        $message = '請輸入新扭蛋圖片網址'; 
        echo "<script type='text/javascript'>alert('$message');</script>";
    }else if(empty($_POST['g_amount'])){
        $message = '請輸入新扭蛋數量'; 
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else{
        $name = $_POST['g_name'];
        $pic = $_POST['g_pic'];
        $amount = $_POST['g_amount'];
    
        if(strlen($name) > 10){
            $message = '長度請限制在10個字以內!'; 
            echo "<script type='text/javascript'>alert('$message');</script>";
            exit();
        }
        if(strlen($pic) > 200){
            $message = '圖片網址長度過長!'; 
            echo "<script type='text/javascript'>alert('$message');</script>";
            exit();
        }
        if($amount<=0)
        {
            $message = '扭蛋數量過低!'; 
            echo "<script type='text/javascript'>alert('$message');</script>";
            exit();
        }

        $insert_sql = "INSERT INTO gashapon(name, picture, amount, machine_id) VALUES('$name', '$pic', '$amount', '$m_id')";
        if ($conn->query($insert_sql) === TRUE){
    
            $update_sql = "UPDATE machine SET amount = amount + 1 WHERE machine_id = '$m_id'";
            $conn->query($update_sql);
            header('Location: '.$_SERVER['REQUEST_URI']);
            ob_end_flush();
        }else{
            echo "<div align='center'> <h2><font color='antiquewith'>ERROR!!請在試一次!</font></h2> </div>";
        }

    }
} 

   // echo "<div align='center'> <h2><font color='antiquewith'></font></h2> </div>";
    if ( isset($_POST['add_amount_to_sql']) && !empty($_POST['new_amount'])){
    $amount = $_POST['new_amount'];
    $get_gashapon_id = $_SESSION['gashapon_id'];

    //$row = mysqli_fetch_row($gashapon_sql);
    //echo row[3];

    if( (row[2]+$amount)<0 )
    {
      $message = '扭蛋數量過低!';
      echo "<script type='text/javascript'>alert('$message');</script>";
      exit();
    }


    $update_sql = "UPDATE `gashapon` set `amount` = `amount` + '$amount' where `gashapon_id` = '$get_gashapon_id'";
    if ($conn->query($update_sql) === TRUE){
        header('Location: '.$_SERVER['REQUEST_URI']);
        ob_end_flush();
    }else{
        echo "<div align='center'> <h2><font color='antiquewith'>ERROR!!請在試一次!</font></h2> </div>";
    }
}
else if ( isset($_POST['add_amount_to_sql']) && (empty($_POST['new_amount'])) ){
    $message = '請填寫扭蛋數量再送出!!';
    echo "<script type='text/javascript'>alert('$message');</script>";
}

?>
