<?php require_once('Connections/connection.php'); ?>
<?php require_once('Connections/function.php'); ?>
<?php
// 建立 session
if (!isset($_SESSION)) {
  session_start();


// 前一個網頁
$_SESSION['PrevPage'] = "index.php";
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
// 在lunchGroup資料表內插入一筆新的紀錄
//**********************************//
if ((isset($_POST["insert"])) && ($_POST["insert"] == "notice")) 
{
	// 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	// 在notice資料表內插入一筆新的紀錄
	$query = sprintf("INSERT INTO lunchGroup (primaryName, shopName, orderDate, userIp, overTime) 
	VALUES (%s, %s, %s, %s, %s)", 
	GetSQLValue($_POST['primaryName'], "text"), GetSQLValue($_POST['shopName'], "text"),
	GetSQLValue($today, "text"), GetSQLValue($userIp, "text"), 
	GetSQLValue($_POST['hours'].":".$_POST['mins'], "text") );
		
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
		<title>主揪</title>
		<script src="JavaScript/create.js" type="text/javascript"></script>
	</head>

	
	
	<body>
		<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
			<table>
				<tr>
					<td><center>主揪姓名:</center></td>
					<td><input name="primaryName" id="primaryName" type="text" maxlength="30" size="25" /></td>
				</tr>
				<tr>
					<td><br/></td>
				</tr>
				<tr>
					<td> </td>
					<td><font size=\"5\" color=\"0000FFFF\">以下是目前已有店家</font>
						，若店家不在選單內，可至右方連結新增店家資訊。
						<a href="shop.php">新增店家</a>
					</td>
				</tr>
				<tr>
					<td><center>今天訂哪家:</center></td>
					<?php
						mysql_select_db('lunch', $connection) or die('資料庫lunch不存在'); 
						
						$query = "SELECT * FROM shop"; 
						// 傳回結果集
						$result = mysql_query($query, $connection) or die(mysql_error());
						$num=mysql_num_rows($result);
					?>
					<td>
						<?php
						if ($result) {
							while ( $row = mysql_fetch_assoc($result) ) {
						?>
								<input type="radio" id="shopName" name="shopName" value="<?php echo $row['shopName'] ?>"><label><?php echo $row['shopName'] ."&nbsp; 電話號碼:". $row['shopPhone'] ?></label>
								<a href="menu.php?shopId=<?php echo $row['id'] ?>">新增菜單</a><br/>
						<?php
							}
							if($num==0)
							{
								echo "<font color=\"#FF0000\">"."目前尚無店家"."</font>"."，可至右上方連結新增店家。";
							}
						}
						?>
						
					</td>
				</tr>
				<tr>
					<td><center>結團時間:</center></td>
					<td>
						<select id="hours" name="hours">
							<option value="-1">請選擇</option>
							<?php
							$nowTime=explode(":",$now);
							for($i=$nowTime[0]+1;$i<24;$i++) {
								$var=sprintf("%02d", $i);
							?>
								<option value="<?php echo $var ?>"><?php echo $var ?></option>
							<?php
							};
							?>
						</select>
						時
						<select id="mins" name="mins">
							<option value="-1">請選擇</option>
							<option value="00">00</option>
							<option value="30">30</option>
						</select>
						分<br>
					</td>
				</tr>
				
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