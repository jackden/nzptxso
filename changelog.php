<?php require_once('Connections/connection.php'); ?>
<?php require_once('Connections/function.php'); ?>
<?php
// 建立 session
if (!isset($_SESSION)) {
  session_start();


// 前一個網頁
$_SESSION['PrevPage'] = "index.php";

$userlevel=0;
$userlevel=$_GET['userlevel'];
}
?>

<?php
	date_default_timezone_set('Asia/Taipei');
	$today=date("Y-m-d");
	//$now=date("H:i:s");
	$now=date("H:i");
?>

<?php
//**********************************//
// 在changeLog資料表內插入一筆新的紀錄
//**********************************//
if ((isset($_POST["insert"])) && ($_POST["insert"] == "notice")) 
{
	// 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	// 在notice資料表內插入一筆新的紀錄
	$query = sprintf("INSERT INTO changeLog (changeDate, changeContent) 
	VALUES (%s, %s)", 
	GetSQLValue($_POST['changeDate'], "text"), GetSQLValue($_POST['changeContent'], "text") );
		
	// 傳回結果集
	$result = mysql_query($query, $connection) or die(mysql_error());
	
	if ($result) {
	    // 回到前一個網頁 
	  	//header(sprintf("Location: %s", $_SESSION['PrevPage']));
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-tw" xml:lang="zh-tw">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>更新紀錄</title>
	</head>

	
	
	<body>
		<?php
			if($userlevel==1) {
		?>
		<h2>新增紀錄</h2>
		<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
			<table>
				<tr>
					<td><center>更新日期:</center></td>
					<td><input name="changeDate" id="changeDate" type="text" maxlength="30" size="25" /></td>
				</tr>
				<tr>
					<td><center>更新內容:</center></td>
					<td><textarea name="changeContent" id="changeContent" /></textarea></td>
				</tr>
				<tr>
					<td><input id="send" name="submit" type="submit" value="送出" onclick="return CheckFields();" /></td>
				</tr>
			</table>
			<input name="insert" id="insert" type="hidden" value="notice" />
		</form>
		<?php
		}
		?>
		
		
		<h2>更新紀錄</h2>
		
		<ul>
		<?php
			mysql_select_db('lunch', $connection) or die('資料庫lunch不存在'); 
			
			$query7 = "SELECT * FROM changeLog order by changeDate DESC"; 
			// 傳回結果集
			$result7 = mysql_query($query7, $connection) or die(mysql_error());
			if ($result7) {
				while ( $row7 = mysql_fetch_assoc($result7) ) {
		?>
		
			<li>
				<span><?php echo $row7['changeDate']; ?></span>
				<span><?php echo $row7['changeContent']; ?></span>
			</li>
		<?php
				}
			}
		?>
		</ul>
		
		<a href="index.php">回到上一頁</a>
	</body>
</html>