<?php //==** check if the user has login or not / if push the logout button what will happen ==**//
    session_start();

    if( !isset($_SESSION['password']) || !isset($_SESSION['enterprise_id'])){
        echo "You have to log in first <br> <h3><a href='login.html'>返回</a></h3>";
        header('location: elogin.html');
    }

    if (isset($_GET['logout'])) {
        //session_destroy();
        unset($_SESSION['password']);
        unset($_SESSION['enterprise_id']);
        header("location: elogin.html");
    }
?>

<?php require_once('connect_db.php') ?>

<?php
    $login_e_id = $_SESSION['enterprise_id']; 
    $machine_sql = mysqli_query($conn, "SELECT * FROM machine WHERE enterprise_id = '$login_e_id'"); // 得到 machine data
?>

<!DOCTYPE html>
<html>
<head>
	<title>線上扭蛋機</title>
		<meta http-equiv="Content-Type" content="text/css; charset=utf-8">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
	
    <div class="container">

        <div class="nav-wrapper">

            <div class="left-side">
                <form action="edit.php" method="post"><input type="submit" value="新增扭蛋機"></form>
            </div>

            <div class="right-side">
                <div class="self-info">
                    <?php 
                        echo "<h3>帳號 : ".$login_e_id."  歡迎！</h3>"; 
                    ?>
                </div>
                <div class="nav-button">
                    <?php 
                        echo "<form action='change_psw.html' method='post'><input type='submit' name='change_password' value='更改密碼'></form>  ";
                    ?>
                </div>
                <div class="nav-button">
                    <?php 
                        echo "<form action='check_acc.php' method='post'><input type='submit' name='check_account' value='查看帳戶'></form>";
                    ?>
                </div>
                <?php echo "<a href='ehome.php?logout='1'' id='logout-button'>登出</a>"; ?>
            </div>     
       

        </div>

        <div class="content-wrapper">
            <h1>您擁有的扭蛋機</h1>
            <div class="machine-wrapper">
            
                    <?php
                        //== 列出每個機器 ==//
                        while($row = mysqli_fetch_row($machine_sql)){  // $row = machine 中的 attribute 那一欄
                            
                            echo "<div class='single-machine-wrapper'><div class='machine-name'>名稱 : ".$row[1]."</div>"; // machine name
                            echo "<div class='machine-img-bg' style='background-image:url($row[3])'>"; // machine pic
                            echo "<div class='details'> 價格 : NT$ ".$row[2]."<br>"; // machine price
                            echo "扭蛋數量 : ".$row[4]."<br>公告內容 : "; // machine amount
                            echo "<form action='edit.php' method='post'>";
                            echo "<textarea rows='10' class='machine_announce'></textarea>"; // machine announce
                            echo "<button type='submit' >發送</button></form>  </div> </div>";
                          // ↓ add button
                            echo "<div class='edit-machine-button'><form action='edit.php' method='post'><button type='submit'>編輯扭蛋機</button></form>";
                            echo "<form action='delete.html' method='post'><button type='submit'>刪除扭蛋機</button></form></div>";
                            echo "</div>";
                            
                        }
                    ?>
                   
                </div>

            </div>
        </div>
    </div>
	
	
</body>
	
</html>
