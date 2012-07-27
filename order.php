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
	$now=date("H:i");
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
	$query = sprintf("INSERT INTO orderLog (userName, groupId, foodName, foodCount, userRemark, userRemark1, orderDate, userIp) 
	VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", 
	GetSQLValue($_POST['userName'], "text"), GetSQLValue($groupId, "int"),
	GetSQLValue($_POST['foodName'], "text"), GetSQLValue($_POST['foodCount'], "int"),
	GetSQLValue($_POST['userRemark'], "text"), GetSQLValue($_POST['userRemark1'], "text"),
	GetSQLValue($today, "text"), GetSQLValue($userIp, "text") );
		
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
					<td><input name="userName" id="userName" type="text" maxlength="10" size="25" title="請輸入姓名" /></td>
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
						
						$query3 = "SELECT shopName, overTime FROM lunchGroup WHERE id = '$groupId' "; 
						// 傳回結果集
						$result3 = mysql_query($query3, $connection) or die(mysql_error());
						if ($result3) { $row3 = mysql_fetch_assoc($result3); }
						$shopName=$row3['shopName'];
						
						$query1 = "SELECT * FROM menu WHERE shopName = '$shopName' "; 
						// 傳回結果集
						$result1 = mysql_query($query1, $connection) or die(mysql_error());
						
						$overTime=explode(":",$row3['overTime']);
						$nowTime=explode(":",$now);
						
						if( ($nowTime[0]<$overTime[0]) || ($nowTime[0]==$overTime[0] && $nowTime[1]<$overTime[1]) ) {
						}
						else {
							header(sprintf("Location: %s", $_SESSION['PrevPage']));
						}
						
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
									}
								?>
								<br/>
						<?php
							}
							if(!$row2)
							{
								echo "<font color=\"#FF0000\">"."目前尚無菜單"."</font>"."，可至右上方連結新增菜單。";
							}
						}
						?>
						
					</td>
				</tr>
				<tr>
					<td><center>備註:</center></td>
					<td>
						<input type="text" id="userRemark1" name="userRemark1" maxlength="10" size="25" title="ex:飯or麵,牛or羊,辣度" />
					</td>
				</tr>
				<tr>
					<td><center>數量:</center></td>
					<td><input name="foodCount" id="foodCount" type="text" maxlength="2" size="5" title="請輸入數量" /></td>
				</tr>
				<tr>
					<td><center>飯量:</center></td>
					<td>
						<input type="radio" id="userRemark" name="userRemark" value="正常" checked="checked"><label>正常</label>
						<input type="radio" id="userRemark" name="userRemark" value="加飯/麵"><label>加飯/麵</label>
						<input type="radio" id="userRemark" name="userRemark" value="減飯/麵"><label>減飯/麵</label><br/>
						<!--- <input type="radio" id="userRemark" name="userRemark" value="去冰"><label>去冰</label>
						<input type="radio" id="userRemark" name="userRemark" value="少冰"><label>少冰</label> --->
					</td>
				</tr>
				<!--- <tr>
					<td><center>甜度:</center></td>
					<td>
						<input type="radio" id="userRemark1" name="userRemark1" value="正常" checked="checked"><label>正常</label>
						<input type="radio" id="userRemark1" name="userRemark1" value="無糖"><label>無糖</label>
						<input type="radio" id="userRemark1" name="userRemark1" value="微糖"><label>微糖(3分)</label><br/>
						<input type="radio" id="userRemark1" name="userRemark1" value="半糖"><label>半糖(5分)</label>
						<input type="radio" id="userRemark1" name="userRemark1" value="少糖"><label>少糖(8分)</label>
					</td>
				</tr> --->
				<tr>
					<td><input id="send" name="submit" type="submit" value="送出" onclick="return CheckFields();" /></td>
				</tr>
				
				<tr>
					<td><a href="index.php">回到上一頁</a></td>
				</tr>
			</table>
			<input name="insert" id="insert" type="hidden" value="notice" />
		</form>
	</body>
</html>