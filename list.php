<?php require_once('Connections/connection.php'); ?>
<?php require_once('Connections/function.php'); ?>
<?php
// 建立 session
if (!isset($_SESSION)) {
  session_start();
}

// 前一個網頁
$_SESSION['PrevPage'] = "index.php";

$groupId=$_GET['groupId'];
if(!$groupId) {header(sprintf("Location: %s", $_SESSION['PrevPage']));}
?>

<?php
//**********************************//
// 在orderLog資料表內插入一筆新的紀錄
//**********************************//
if (($_POST["insert"] == "49821032")) 
{
	// 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	for($i=0;$i<count($isPayed);$i++)
	{
		$temp=$isPayed[$i];
		// 在orderLog資料表內插入一筆新的紀錄
		$query = "UPDATE orderLog SET isPayed = '1' WHERE id = '$temp' ";
			
		// 傳回結果集
		$result = mysql_query($query, $connection) or die(mysql_error());
	}
	
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
		<meta content='10' http-equiv='Refresh'/>
		<title>統計頁面</title>
		
		<style>
			table {  
			  border: 1px solid #000000;  
			  border-collapse: collapse;  
			  text-align:center;
			  margin-top:100px;
			}  
			tr, td {  
			  border: 1px solid #000000;  
			}  
		</style>
	</head>

	
	
	<body>
	<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
		<table style="position:relative; margin-left:auto; margin-right:auto; width:50%; ">
			<tr>
				<td>
					訂單
				</td>
				<td>
					付了嗎?
				</td>
			</tr>
			<?php
			mysql_select_db('lunch', $connection) or die('資料庫lunch不存在'); 
			
			$query1 = "SELECT * FROM orderLog order by foodName"; 
			// 傳回結果集
			$result1 = mysql_query($query1, $connection) or die(mysql_error());
			if ($result1) {
				while ( $row1 = mysql_fetch_assoc($result1) ) {
					if ($row1['groupId']==$groupId) {
			?>
						<tr>
							<td bgColor="#E6E6FA">
								<?php 
									$temp1=$row1['foodName'];
									echo $row1['userName'] . "&nbsp;" . $row1['foodCount'] . "個&nbsp;" . $row1['foodName'];
									if($row1['userRemark']=="加飯/麵") { echo "&nbsp;加飯/麵"; }
									if($row1['userRemark']=="減飯/麵") { echo "&nbsp;減飯/麵"; }
									if($row1['userRemark']=="去冰") { echo "&nbsp;去冰"; }
									if($row1['userRemark']=="少冰") { echo "&nbsp;少冰"; }
								?>
								<?php 
									$query2 = "SELECT shopName FROM lunchGroup WHERE id = '$groupId' ";
									// 傳回結果集
									$result2 = mysql_query($query2, $connection) or die(mysql_error());
									if ($result2) { $row2 = mysql_fetch_assoc($result2); }
									$shopName=$row2['shopName'];
								
									$query3 = "SELECT foodPrice FROM menu WHERE shopName = '$shopName' AND foodName = '$temp1' ";
									// 傳回結果集
									$result3 = mysql_query($query3, $connection) or die(mysql_error());
									if ($result3) { $row3 = mysql_fetch_assoc($result3); }
								?>
							</td>
							<?php
								if($row1['isPayed']==0) {
							?>
							<td>
								<input type="checkbox" id="isPayed" name="isPayed[]" value="<?php echo $row1['id']; ?>"><?php echo $row1['foodCount']*$row3['foodPrice']."元"; ?>
							</td>
							<?php
								}
							?>
							<?php
								if($row1['isPayed']!=0) {
							?>
							<td>
								<input type="checkbox" id="isPayed" name="isPayed[]" checked disabled><?php echo $row1['foodCount']*$row3['foodPrice']."元"; ?>
							</td>
							<?php
								}
							?>
						</tr>
			<?php
					};
				};
			}
			?>

		</table>

		
		<div align="center" style="margin-top:10px; margin-right:100px;">
			主揪專屬密碼：<input name="insert" id="insert" type="password" />
			<input id="send" name="submit" type="submit" value="送出" />
		</div><br/>

	</form>
		<center><a href="index.php">回到上一頁</a></center>
	</body>
</html>