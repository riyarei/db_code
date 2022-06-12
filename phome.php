<?php //==** check if the user has login or not / if push the logout button what will happen ==**//
    session_start();

    if( !isset($_SESSION['password']) || !isset($_SESSION['player_id'])){
        echo "You have to log in first <br> <h3><a href='plogin.html'>返回</a></h3>";
        header('location: plogin.html');
    }

    if (isset($_GET['logout'])) {
        //session_destroy();
        unset($_SESSION['password']);
        unset($_SESSION['player_id']);
        header("location: plogin.html");
    }
?>

<?php require_once('connect_db.php') ?>

<?php
    $login_e_id = $_SESSION['player_id']; 
    $machine_sql = mysqli_query($conn, "SELECT * FROM machine "); // 得到 machine data
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
                        echo "<form action='check_acc_p.php' method='post'><input type='submit' name='check_account' value='查看帳戶'></form>";
                    ?>
                </div>
                <?php echo "<a href='phome.php?logout='1'' id='logout-button'>登出</a>"; ?>
            </div>     
       

        </div>

        <div class="content-wrapper">
            <h1>扭蛋機</h1>
            <div class="machine-wrapper">
            
                    <?php
                        //== 列出每個機器 ==//
                        while($row = mysqli_fetch_row($machine_sql)){  // $row = machine 中的 attribute 那一欄
                            
                            $machine_id = $row[0];
                            
                            echo "<div class='single-machine-wrapper'><div class='machine-name'>名稱 : ".$row[1]."</div>"; // machine name
                            echo "<div class='machine-img-bg' style='background-image:url($row[3])'>"; // machine pic
                            echo "<div class='details'> 價格 : NT$ ".$row[2]."<br>"; // machine price
                            echo "扭蛋數量 : ".$row[4]."<br>公告內容 : "; // machine amount

                            //查詢此扭蛋機的所有公告
                            $announce_sql = mysqli_query( $conn , "SELECT content FROM announces WHERE machine_id = $machine_id");

                            //印出所有扭蛋機公告
                            while($announce = mysqli_fetch_row($announce_sql))
                            {
                                echo $announce[0] . "<br>";
                            }

                            //保留玩家可以對此扭蛋機進行反饋的地方，但action的edit.php檔可能需要修改
                            echo "<form action='edit.php' method='post'>";
                            echo "<textarea rows='10' class='machine_announce'></textarea>"; // machine announce
                            echo "<button type='submit' >發送</button></form>  </div> </div>";
                          // ↓ add button
                            // echo "<div class='edit-machine-button'><form action='edit.php' method='post'><button type='submit'>編輯扭蛋機</button></form>";
                            // echo "<form action='delete.html' method='post'><button type='submit'>刪除扭蛋機</button></form></div>";
                            echo "</div>";
                            
                        }
                    ?>
                   
                </div>

            </div>
        </div>
    </div>
	
	
</body>
	
</html>