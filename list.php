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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-tw" xml:lang="zh-tw">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>統計頁面</title>
		
		<style>
			table {  
			  border: 1px solid #000000;  
			  border-collapse: collapse;  
			  text-align:center;
			}  
			tr, td {  
			  border: 1px solid #000000;  
			}  
		</style>
	</head>

	
	
	<body>
		<!--- <table style="position:relative; margin-left:auto; margin-right:auto; width:40%; ">
			<tr>
				<td>
					訂單
				</td>
				<td>
					付了嗎?
				</td>
				<td>
					領了嗎?
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
									echo $row1['userName'] . "&nbsp;" . $row1['foodCount'] . "個&nbsp;" . $row1['foodName'];
									if($row1['userRemark']=="加飯/麵") { echo "&nbsp;加飯/麵"; }
									if($row1['userRemark']=="減飯/麵") { echo "&nbsp;減飯/麵"; }
									if($row1['userRemark']=="去冰") { echo "&nbsp;去冰"; }
									if($row1['userRemark']=="少冰") { echo "&nbsp;少冰"; }
								?>
							</td>
							<td>
								<input type="checkbox" id="pay" name="pay[]" onclick="pay.disabled=!pay.disabled">
							</td>
							<td>
								<input type="checkbox" id="take" name="take[]" onclick="take.disabled=!take.disabled">
							</td>
							<?php
								if($userlevel==1) {
							?>
								<td>
									<input type="button" value="X" onclick="self.location.href='delete.php?groupId=<?php echo $row1['id'] ?>&userlevel=1'">
								</td>
							<?php
								};
							?>
						</tr>
			<?php
					};
				};
			}
			?>
		</table> --->
		功能尚未開放。<br/>
		<a href="index.php">回到上一頁</a>
	</body>
</html>