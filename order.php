<?php require_once('Connections/connection.php'); ?>
<?php require_once('Connections/function.php'); ?>
<?php
// 建立 session
if (!isset($_SESSION)) {
  session_start();


// 前一個網頁
$_SESSION['PrevPage'] = "index.php";

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
	date_default_timezone_set('Asia/Taipei');
	$today=date("Y-m-d");
?>

<?php
//**********************************//
// 在orderLog資料表內插入一筆新的紀錄
//**********************************//
if ((isset($_POST["insert"])) && ($_POST["insert"] == "notice")) 
{
	// 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	// 在orderLog資料表內插入一筆新的紀錄
	$query = sprintf("INSERT INTO orderLog (userName, groupId, foodName, foodCount, userRemark, orderDate, userIp) 
	VALUES (%s, %s, %s, %s, %s, %s, %s)", 
	GetSQLValue($_POST['userName'], "text"), GetSQLValue($groupId, "int"),
	GetSQLValue($_POST['foodName'], "text"), GetSQLValue($_POST['foodCount'], "int"),
	GetSQLValue($_POST['userRemark'], "int"), GetSQLValue($today, "text"),
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
		<title>午餐吃什麼♥</title>
		
		<script type="text/javascript" src="js/prototype.js"></script>
		<script type="text/javascript" src="js/scriptaculous.js?load=effects"></script>
		<script src="js/lightbox.js"></script>
		<link href="css/lightbox.css" rel="stylesheet" />
		
		<script src="JavaScript/order.js" type="text/javascript"></script>
	</head>

	
	
	<body>
		<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
			<table>
				<tr>
					<td><center>姓名:</center></td>
					<td><input name="userName" id="userName" type="text" maxlength="10" size="25" /></td>
				</tr>
				<tr>
					<td> </td>
					<td><font size=\"5\" color=\"0000FFFF\">以下是目前已有菜單</font>
						，若店家有新菜單，或菜單不在選單內，可至右方連結新增菜單。
						<a href="menu.php?groupId=<?php echo $groupId ?>">新增菜單</a>
					</td>
				</tr>
				<tr>
					<td>餐點名稱:</td>
					<?php
						mysql_select_db('lunch', $connection) or die('資料庫lunch不存在'); 
						
						$orderDate=$today;
						
						$query3 = "SELECT shopName FROM lunchgroup WHERE id = '$groupId' "; 
						// 傳回結果集
						$result3 = mysql_query($query3, $connection) or die(mysql_error());
						if ($result3) { $row3 = mysql_fetch_assoc($result3); }
						$shopName=$row3['shopName'];
						
						$query1 = "SELECT * FROM menu WHERE shopName = '$shopName' "; 
						// 傳回結果集
						$result1 = mysql_query($query1, $connection) or die(mysql_error());
					?>
					<td>
						<?php
						
						if ($result1) {
							while ( $row1 = mysql_fetch_assoc($result1) ) {
								$foodName=$row1['foodName'];
								
								$query2 = "SELECT filename FROM menu WHERE shopName = '$shopName' AND foodName = '$foodName' "; 
								// 傳回結果集
								$result2 = mysql_query($query2, $connection) or die(mysql_error());
								if ($result2) { $row2 = mysql_fetch_assoc($result2); }
						?>
								<input type="radio" id="foodName" name="foodName" value="<?php echo $row1['foodName'] ?>"><label><?php echo $row1['foodName'] ."&nbsp;". $row1['foodPrice'] ."元" ?></label>
								<?php
									if($row2['filename']) {
								?>
										<a href="showimg.php?filename=<?php echo $row2['filename'] ?>" rel="lightbox" title="<?php echo $row1['foodName'] ?>">圖片</a>
								<?php
									};
								?>
								</br>
						<?php
							};
						}
						?>
						
					</td>
				</tr>
				<tr>
					<td><center>數量:</center></td>
					<td><input name="foodCount" id="foodCount" type="text" maxlength="2" size="5"  /></td>
				</tr>
				<tr>
					<td><center>是否加飯:</center></td>
					<td>
						<input type="radio" id="userRemark" name="userRemark" value="1"><label>加飯/麵</label>
						<input type="radio" id="userRemark" name="userRemark" value="0" checked="checked"><label>正常</label>
						<input type="radio" id="userRemark" name="userRemark" value="-1"><label>減飯/麵</label>
					</td>
				</tr>
				<tr>
					<td><input id="send" name="submit" type="submit" value="送出" onclick="return CheckFields();" /></td>
				</tr>
			</table>
			<input name="insert" id="insert" type="hidden" value="notice" />
		</form>
	</body>
</html>