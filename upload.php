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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-tw" xml:lang="zh-tw">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>上傳菜單照片</title>
		
		<script type="text/javascript" src="selectbox/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="selectbox/selectboxes.js"></script>
		<script type="text/javascript" src="selectbox/index.js"></script>
		
		<script src="JavaScript/upload.js" type="text/javascript"></script>
	</head>

	
	
	<body>
		<form method="post" enctype="multipart/form-data" action="checkPic.php">
			<table>
				<tr>
					<td><center>店家名稱:</center></td>
					<?php
						mysql_select_db('lunch', $connection) or die('資料庫lunch不存在'); 
						
						$query = "SELECT * FROM shop"; 
						// 傳回結果集
						$result = mysql_query($query, $connection) or die(mysql_error());
					?>
					<td>
						<select id="select1" name="select1">
						<option value="0">請選擇</option>
						<?php
						if ($result) {
							 while ($row = mysql_fetch_assoc($result)) {
								echo '<option value="' . $row['shopName'] . '">' . $row['shopName'] . '</option>' . "\n";
							}
						}
						?>
						</select>						
					</td>
				</tr>
				<tr>
					<td><center>菜單:</center></td>
					<td>
						<select id="select2" name="select2">
							<option value="0">請選擇</option>
						</select>
					</td>
					<td>
						<Input Type="File" id="upfile" Name="upfile" ><br>
					</td>
				</tr>
				
				<tr>
					<td><input id="send" name="submit" type="submit" value="開始上傳" onclick="return CheckFields();" /></td>
				</tr>
			</table>
			<input name="insert" id="insert" type="hidden" value="notice" />
		</form>
	</body>
</html>