<?php require_once('Connections/connection.php'); ?>
<?php require_once('Connections/function.php'); ?>
<?php
// 建立 session
if (!isset($_SESSION)) {
  session_start();


// 前一個網頁
$_SESSION['PrevPage'] = "create.php";
}
?>

<?php
if(!empty($_SERVER['HTTP_CLIENT_IP'])){
   $userIp = $_SERVER['HTTP_CLIENT_IP'];
}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
   $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
   $userIp= $_SERVER['REMOTE_ADDR'];
}
//echo $userIp;
?>

<?php
//**********************************//
// 在shop資料表內插入一筆新的紀錄
//**********************************//
if ((isset($_POST["insert"])) && ($_POST["insert"] == "notice")) 
{
	// 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	// 在notice資料表內插入一筆新的紀錄
	$query = sprintf("INSERT INTO shop (shopName, shopPhone, userIp) 
	VALUES (%s, %s, %s)", 
	GetSQLValue($_POST['shopName'], "text"), GetSQLValue($_POST['shopPhone'], "text"),
	GetSQLValue($userIp, "text") );
		
	// 傳回結果集
	$result = mysql_query($query, $connection) or die(mysql_error());
	
	if ($result) {
	    // 回到前一個網頁 
	  	header(sprintf("Location: %s", $_SESSION['PrevPage']));
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-tw" xml:lang="zh-tw">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>新增店家</title>
		
		<script src="JavaScript/shop.js" type="text/javascript"></script>
	</head>

	<body>
		<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
			<table>
				<tr>
					<td><center>店家名稱:</center></td>
					<td><input name="shopName" id="shopName" type="text" maxlength="30" size="25" /></td>
				</tr>
				<tr>
					<td><center>店家電話:</center></td>
					<td><input name="shopPhone" id="shopPhone" type="text" maxlength="30" size="25" /></td>
				</tr>
				
				
				<tr>
					<td><input id="send" name="submit" type="submit" value="送出" onclick="return CheckFields();" /></td>
				</tr>
				
				<tr>
					<td><a href="create.php">回到上一頁</a></td>
				</tr>
			</table>
			<input name="insert" id="insert" type="hidden" value="notice" />
		</form>
	</body>
</html>