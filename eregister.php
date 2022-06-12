<?php require_once('connect_db.php') ?>
<?php 
    $e_id_sql = mysqli_query($conn, "SELECT max(enterprise_id) FROM enterprise"); // 得到 machine data
	while($row = mysqli_fetch_row($e_id_sql)){
		$register_id = $row[0];
	}
    $register_id = $register_id + 1;
?>
<html>
<head>
	<title>線上扭蛋機</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/tw-city-selector@2.1.0/dist/tw-city-selector.min.js"></script>
</head>
<body>
	
	<h1 align="center">商家帳號註冊</h1>
	<form action="eregister_bg.php" method="post">	
	  <table width="500" border="1" bgcolor="#cccccc" align="center">
		<tr>
		  	<th>帳號 (已設定)</th>
		  	<td bgcolor="#FFFFFF"> 
               <?php echo $register_id; ?>
			</td>
		</tr>
		<tr>
		  <th>密碼</th>
		  <td bgcolor="#FFFFFF"><input type="text" name="password"  /></td>
		</tr>
		<tr>
		  <th>帳戶</th>
		  <td bgcolor="#FFFFFF">
			  <input type="text" name="account" >
			</td>
		</tr>
		
		<tr>
		  <th colspan="2"><input type="submit" value="註冊"/></th>
		  
		</tr>
	  </table>
	</form>
	
</body>
	
</html>
<script>
	new TwCitySelector();
</script>