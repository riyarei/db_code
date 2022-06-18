<?php //==** check if the user has login or not / if push the logout button what will happen ==**//
    session_start();
    ob_start();

    if( !isset($_SESSION['password']) || !isset($_SESSION['enterprise_id'])){
        echo "You have to log in first <br> <h3><a href='login.html'>返回</a></h3>";
        header('location: elogin.html');
        ob_end_flush();
    }

    if (isset($_GET['logout'])) {
        //session_destroy();
        unset($_SESSION['password']);
        unset($_SESSION['enterprise_id']);
        unset($_SESSION['machine_id']);
        header("location: home.html");
        ob_end_flush();
    }
?>

<?php require_once('connect_db.php') ?>

<?php
    $login_e_id = $_SESSION['enterprise_id']; 
    $machine_sql = mysqli_query($conn, "SELECT * FROM machine WHERE enterprise_id = '$login_e_id' ORDER by price ASC;"); // 得到 machine data
    
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
                <form action="add_machine.php" method="post"><input type="submit" value="新增扭蛋機"></form>
            </div>

            <div class="right-side">
                <div class="self-info">
                    <?php 
                        echo "<h3>帳號 : ".$login_e_id."  歡迎！</h3>"; 
                    ?>
                </div>
                <div class="nav-button">
                    <?php 
                        echo "<form action='change_psw.php' method='post'><input type='submit' name='change_password' value='更改密碼'></form>  ";
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
            <h2>價格低到高</h2>
            <div class="nav-button">
                    <?php 
                        echo "<form action='ehome_orderDESC.php' method='post'><input type='submit' name='machine_desc' value='切換成價格高到低排序'></form>  ";
                    ?>
            </div>
            <div class="machine-wrapper">
            
                    <?php
                        //== 列出每個機器 ==//
                        while($row = mysqli_fetch_row($machine_sql)){  // $row = machine 中的 attribute 那一欄
                            
                            echo "<div class='single-machine-wrapper'><div class='machine-name'>名稱 : ".$row[1]."</div>"; // machine name
                            echo "<div class='machine-img-bg' style='background-image:url($row[3])'>"; // machine pic
                            echo "<div class='details'> 價格 : NT$ ".$row[2]."<br>"; // machine price
                            echo "扭蛋種類 : ".$row[4]."<br>公告內容 : "; // machine amount
                            echo "<form action='' method='post'>";
                            echo "<textarea rows='10' class='machine_announce' name='announces'></textarea>"; // machine announce
                            echo "<button name='announce_id' type='submit' value='$row[0]' >發送</button></form>  </div> </div>";
                          // ↓ add button
                            echo "<div class='edit-machine-button'><form action='' method='post'><button name='edit_id' type='submit' value='$row[0]'>編輯扭蛋機";
                            echo "</button></form>";
                            echo "<form action='' method='post'><button name='delete_id' type='submit' value='$row[0]'>刪除扭蛋機</button></form></div>";
                            echo "</div>";
                            
                        }
                        /*== edit one machine ==*/
                        if(isset($_POST['edit_id']) ){
                            $_SESSION['machine_id'] = $_POST['edit_id'];
                            header("Location: edit.php");
                            ob_end_flush();
                        } 
                    ?>
                   
                </div>
                        <?php 
                        /*== delete one machine ==*/
                            if(isset($_POST['delete_id']) ){
                                $delete_machine = $_POST['delete_id'];
                                
                                $check = "SELECT * FROM ((orderform JOIN gashapon USING(gashapon_id))JOIN machine USING(machine_id)) 
                                WHERE machine_id = '$delete_machine' and enterprise_id = '$login_e_id' and send=0";

                                $check_sql = mysqli_query($conn, $check);
                               // echo "<br> ".$check." <br>";
                                //printf("ERROR : %s\n", mysqli_num_rows($check_sql));
                                if(mysqli_num_rows($check_sql) > 0){
                                    //echo "<br> yes <br>";
                                    $message = '有其他玩家尚未寄送這個扭蛋機裡的扭蛋，不能刪除';
                                    echo "<script type='text/javascript'>alert('$message');</script>";
                                }else{
                                    $delete_sql = "DELETE FROM machine WHERE machine_id = '$delete_machine'";
                                    $delete_sql = mysqli_query($conn, $delete_sql);
                                    $conn->query($delete_sql);
                                    //echo "<br> no <br>";
                                    header('Location: '.$_SERVER['REQUEST_URI']);
                                    ob_end_flush();
                                }
                                
                            } 

                        /*== enterprise announce content to players ==*/
                            if(strlen($_POST['announces'])>1000) {
                                $message = '公告1000個字以內!'; 
                                echo "<script type='text/javascript'>alert('$message');</script>";
                                exit();
                            }
                            else if(isset($_POST['announce_id']) ){
                                $text = $_POST['announces']; 
                                $m_id = $_POST['announce_id'];

                                //echo "<br> text : ". $text. "<br>machine id : ".$m_id."<br> login id : ".$login_e_id;
                                $has_text_before = mysqli_query($conn,"SELECT * from announces WHERE enterprise_id = '$login_e_id' and machine_id = '$m_id'");
                                
                                if(mysqli_num_rows($has_text_before) == 1){
                                    $a_sql = "UPDATE announces SET content = '$text' WHERE enterprise_id = '$login_e_id' and machine_id = '$m_id'";
                                    $a_sql = mysqli_query($conn, $a_sql);
                                }else{
                                    $a_sql = "INSERT INTO announces(enterprise_id, machine_id, content) VALUES('$login_e_id', '$m_id', '$text')";
                                    $a_sql = mysqli_query($conn, $a_sql);
                                }
                                
                                if($conn->query($a_sql) === TRUE){
                                    header('Location: '.$_SERVER['REQUEST_URI']);
                                    ob_end_flush();
                                }
        
                                
                            } 
                        ?>
            </div>
        </div>
    </div>
    
    
</body>
    
</html>