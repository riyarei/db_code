<?php //==** check if the user has login or not / if push the logout button what will happen ==**//
    session_start();
    require_once('connect_db.php') ;

    $login_e_id = $_SESSION['enterprise_id']; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>線上扭蛋機</title>
		<meta http-equiv="Content-Type" content="text/css; charset=utf-8">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
	<h1 align='center'>新增扭蛋機</h1>
    <form action='' method='post'>
        <table width="500" border="1" bgcolor="#cccccc" align="center">
            <tr>
                <th>扭蛋機名稱</th>
                <td bgcolor="#FFFFFF"><input type="text" name="name" /></td>
            </tr>
            <tr>
                <th>售價</th>
                <td bgcolor="#FFFFFF"><input type="text" name="price"  /></td>
            </tr>
            <tr>
                <th>扭蛋機圖片連結</th>
                <td bgcolor="#FFFFFF"><input type="text" name="picture" /></td>
            </tr>
            
        </table>
		<br>
        <div align='center'><input type="submit" name='submit' value="新增"></div>
    </form>
	<br>
    <div align='center'>
    <form action="ehome.php"><input type="submit" value="返回"></form>
	</div>
</body>
	
</html>
<?php
    /*$temp = $_POST['name'];
    //echo $temp[0];
    $i=0;
    $len=strlen($temp);
    echo $len."<br>";
    $standard = "/^[\x7f-\xff]/";
    while( $i<strlen($temp) )
    {
        //if(preg_match"/[\x7f-\xff]/", $temp, $match ) )
        if (preg_match($standard, $temp[$i], $result))
        {
            echo $i." ".$temp[$i]."<br>";
            $len=$len-2;
            $i=$i+2;
        }
        $i=$i+1;
    }
    echo $len;*/
    if(!empty($_POST['submit'])){
	 // if name length over 10
	   if(strlen($_POST['name']) > 10){
            $temp = $_POST['name'];
            //echo $temp[0];
            $i=0;
            $len=strlen($temp);
            //echo $len."<br>";
            $standard = "/^[\x7f-\xff]/";
            while( $i<strlen($temp) )
            {
                //if(preg_match"/[\x7f-\xff]/", $temp, $match ) )
                if (preg_match($standard, $temp[$i], $result))
                {
                    //echo $i." ".$temp[$i]."<br>";
                    $len=$len-2;
                    $i=$i+2;
                }
                $i=$i+1;
            }
            //echo $len;

            if($len>10)
            {
                $message = '名字長度請限制在10個字以內!'; 
                echo "<script type='text/javascript'>alert('$message');</script>";
                exit();
            }
        }
        //echo "1 : ".isset($_POST['name'])."<br>2 : ".isset($_POST['name'])." ".$_POST['price']."<br>3 : ".$_POST['picture'];
        if(empty($_POST['name'])){ $message = '請填扭蛋機名字'; echo "<script type='text/javascript'>alert('$message');</script>";  }
        else if(empty($_POST['price'])){
            $message = '請填扭蛋機價格'; echo "<script type='text/javascript'>alert('$message');</script>";
        }else if(empty($_POST['picture'])){
            $message = '請填圖片的網址'; echo "<script type='text/javascript'>alert('$message');</script>";
        }
        // if picture length over 50
        else if(strlen($_POST['picture']) > 200){
            $message = '圖片網址長度過長!'; 
            echo "<script type='text/javascript'>alert('$message');</script>";
            exit();
        }else{
            //echo "<br> ENTER";
            $name = $_POST['name'];
            $price = $_POST['price'];
            $picture = $_POST['picture'];

            $sql = "INSERT INTO machine(name, price, picture, amount, enterprise_ID) VALUES('$name', '$price', '$picture', 0, '$login_e_id')";
            if ($conn->query($sql) === TRUE){
                $sql = "UPDATE machine SET amount = amount - 1 WHERE machine_id = '$m_id'";
                $conn->query($sql);
                header('Location: ehome.php');
            }
            else
                echo "資料不完全";
        }
    }
?>
