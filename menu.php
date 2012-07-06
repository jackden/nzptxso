<?php require_once('Connections/connection.php'); ?>
<?php require_once('Connections/function.php'); ?>
<?php
// 建立 session
if (!isset($_SESSION)) {
  session_start();


// 前一個網頁
$_SESSION['PrevPage'] = "order.php?groupId=".$groupId;

$_SESSION['menuCount'] = 0;
$_SESSION['menuCount'] = $_POST['menuCount'];

$groupId=$_GET['groupId'];
if(!$groupId) {header(sprintf("Location: %s", $_SESSION['PrevPage']));}
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
// 在menu資料表內插入一筆新的紀錄
//**********************************//
if ((isset($_POST["insert"])) && ($_POST["insert"] == "notice")) 
{
	// 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	$query1 = "SELECT shopName FROM lunchgroup WHERE id = '$groupId' "; 
	// 傳回結果集
	$result1 = mysql_query($query1, $connection) or die(mysql_error());
	if ($result1) { $row1 = mysql_fetch_assoc($result1); }
	$shopName=$row1['shopName'];
	
	for($i=0;$i<count($foodName);$i++)
	{
		// 在menu資料表內插入一筆新的紀錄
		$query = sprintf("INSERT INTO menu (shopName, foodName, foodPrice, userIp) 
		VALUES (%s, %s, %s, %s)", 
		GetSQLValue($shopName, "text"), GetSQLValue($foodName[$i], "text"),
		GetSQLValue($foodPrice[$i], "int"), GetSQLValue($userIp, "text") );
			
		// 傳回結果集
		$result = mysql_query($query, $connection) or die(mysql_error());
	}
	
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
		<title>新增菜單</title>
		
		<script src="JavaScript/menu.js" type="text/javascript"></script>
	</head>
	
	<body>
		<?php
			if($_SESSION['menuCount']==0) {
		?>
		<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
			輸入要增加幾筆菜單
			<input name="menuCount" id="menuCount" type="int" maxlength="30" size="5" />
			<input id="send" name="submit" type="submit" value="送出" onclick="return CheckFields();" />
		</form>
		<?php
			};
			if($_SESSION['menuCount']!=0) {
		?>
		<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
			<table>
				<tr>
					<td><center>名稱</center></td>
					<td><center>價格</center></td>
				</tr>
				<?php
					for($i=0;$i<$_SESSION['menuCount'];$i++) {
				?>
				<tr>
					<td><input name="foodName[]" id="foodName" type="text" maxlength="30" size="25" /></td>
					<td><center><input name="foodPrice[]" id="foodPrice" type="int" maxlength="30" size="5" />元</center></td>
				</tr>
				<?php
					};
				?>
				
				<tr>
					<td><input id="send" name="submit" type="submit" value="送出" onclick="return CheckFields1();" /></td>
				</tr>
			</table>
			<input name="insert" id="insert" type="hidden" value="notice" />
		</form>
		<?php
			};
		?>
	</body>
</html>