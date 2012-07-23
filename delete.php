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
if(!$userlevel) {header(sprintf("Location: %s", $_SESSION['PrevPage']));}
$groupId=$_GET['groupId'];
if(!$groupId) {header(sprintf("Location: %s", $_SESSION['PrevPage']));}
}
?>

<?php
//**********************************//
// 刪除紀錄
//**********************************//

// 選擇 MySQL 資料庫lunch
mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');

if($userlevel==2) {
	// 在lunchGroup資料表內刪除紀錄
	$query ="DELETE FROM lunchGroup WHERE id = '$groupId' ";
		
	// 傳回結果集
	$result = mysql_query($query, $connection) or die(mysql_error());

	// 在orderlog資料表內刪除紀錄
	$query2 ="DELETE FROM orderLog WHERE groupId = '$groupId' ";
		
	// 傳回結果集
	$result2 = mysql_query($query2, $connection) or die(mysql_error());
	
	if ($result && $result2) {
		// 回到前一個網頁 
		header(sprintf("Location: %s", $_SESSION['PrevPage']));
	}
}

if($userlevel==1) {
	// 在orderlog資料表內刪除紀錄
	$query3 ="DELETE FROM orderLog WHERE id = '$groupId' ";
		
	// 傳回結果集
	$result3 = mysql_query($query3, $connection) or die(mysql_error());
	
	if ($result3) {
		// 回到前一個網頁 
		header(sprintf("Location: %s", $_SESSION['PrevPage']));
	}
}



?>