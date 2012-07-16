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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-tw" xml:lang="zh-tw">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>訂午餐系統</title>
		
		<style>
			table {  
			  border: 1px solid #000000;  
			  border-collapse: collapse;  
			}  
			tr, td {  
			  border: 1px solid #000000;  
			}  
		</style>
	</head>

	
	
	<body>
		<a href="create.php">我要當主揪</a>
		</br></br>
		<a href="upload.php">上傳菜單照片</a>
		</br></br>
		<!--- <font size="5px" color="FF0000">聲明:請各位資網中心的高手不要攻擊我的網站，小的能力淺薄，這是方便大家訂餐的簡單網頁而已，還請各位高抬貴手</font>
		</br></br> --->
		</br></br>
		
		<div style="font-size:20px"><b><?php echo $today ?>的團購</b></div>
		</br>
		<?php
		mysql_select_db('lunch', $connection) or die('資料庫lunch不存在'); 
		?>
		
		<?php
		$query = "SELECT * FROM lunchGroup WHERE orderDate='$today' order by id DESC"; 
		// 傳回結果集
		$result = mysql_query($query, $connection) or die(mysql_error());
		$num=mysql_num_rows($result);
		if ($result) {
			while ( $row = mysql_fetch_assoc($result) ) {
				$totalMoney=0;
				$allCount=0;
		?>
		<table>
			<tr>
				<td>
					<a href="list.php?groupId=<?php echo $row['id'] ?>"><?php echo $row['primaryName'] . "的團" ?></a>
				</td>
				<td>
					<?php echo "今天中午訂" . "<font size=\"5\" color=\"FF0000\">" . $row['shopName'] . "</font>"; $shopName=$row['shopName']; ?>
				</td>
				<?php
					if($userlevel==1) {
				?>
					<td>
						<input type="button" value="X" onclick="self.location.href='delete.php?groupId=<?php echo $row['id'] ?>&userlevel=2'">
					</td>
				<?php
					};
				?>
			</tr>
			<tr>
				<?php
					$overTime=explode(":",$row['overTime']);
					$nowTime=explode(":",$now);
					
					if( ($nowTime[0]<$overTime[0]) || ($nowTime[0]==$overTime[0] && $nowTime[1]<$overTime[1]) ) {
				?>
					<td>
						<a href="order.php?groupId=<?php echo $row['id'] ?>">我要訂購</a><br/>
						結團時間為<?php echo $row['overTime'] ?>
					</td>
				<?php
					}
					else {
				?>
					<td>
						訂購時間已過<br/>
						結團時間為<?php echo $row['overTime'] ?>
					</td>
				<?php
					}
					
				?>
				<td>
					<?php
					$query5 = "SELECT shopPhone FROM shop WHERE shopName = '$shopName'";
					// 傳回結果集
					$result5 = mysql_query($query5, $connection) or die(mysql_error());
					if ($result5) { $row5 = mysql_fetch_assoc($result5); }
					echo "電話:" . "<font size=\"4\" color=\"FF0FFF\">" . $row5['shopPhone'] . "</font>";
					?>
				</td>
			</tr>
			
			<?php
			$query1 = "SELECT * FROM orderLog order by foodName"; 
			// 傳回結果集
			$result1 = mysql_query($query1, $connection) or die(mysql_error());
			if ($result1) {
				while ( $row1 = mysql_fetch_assoc($result1) ) {
					if ($row1['groupId']==$row['id']) {
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
							</td>
							<td bgColor="#E6E6FA">
								<?php 
									$query6 = "SELECT foodPrice FROM menu WHERE shopName = '$shopName' AND foodName = '$temp1' ";
									// 傳回結果集
									$result6 = mysql_query($query6, $connection) or die(mysql_error());
									if ($result6) {
										while ( $row6 = mysql_fetch_assoc($result6) ) {
											echo "共".$row1['foodCount']*$row6['foodPrice']."元";
										};
									};
								?>
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
			
			<?php
			
			
			$query2 = "SELECT foodName FROM menu WHERE shopName = '$shopName'";
			// 傳回結果集
			$result2 = mysql_query($query2, $connection) or die(mysql_error());
			if ($result2) {
				while ( $row2 = mysql_fetch_assoc($result2) ) {
					$temp=$row2['foodName'];
					
					$totalCount=0;
					$a=0;$b=0;$c=0;$d=0;$e=0;
					$people="";
					$query3 = "SELECT * FROM orderLog WHERE foodName = '$temp'";
					// 傳回結果集
					$result3 = mysql_query($query3, $connection) or die(mysql_error());
					if ($result3) {
						$query4 = "SELECT foodPrice FROM menu WHERE foodName = '$temp' AND shopName = '$shopName'";
						// 傳回結果集
						$result4 = mysql_query($query4, $connection) or die(mysql_error());
						if ($result4) { $row4 = mysql_fetch_assoc($result4); }
						
						while ( $row3 = mysql_fetch_assoc($result3) ) {
							if ($row3['groupId']==$row['id']) {
								$people .= $row3['userName'] . "&nbsp;" . $row3['foodCount'] . "個" . ",";
								$totalCount += $row3['foodCount'];
								
								$totalMoney += $row3['foodCount'] * $row4['foodPrice'];
								if($row3['userRemark']=="正常") { $a += $row3['foodCount']; };
								if($row3['userRemark']=="加飯/麵") { $b += $row3['foodCount']; };
								if($row3['userRemark']=="減飯/麵") { $c += $row3['foodCount']; };
								if($row3['userRemark']=="去冰") { $d += $row3['foodCount']; };
								if($row3['userRemark']=="少冰") { $e += $row3['foodCount']; };
							};
						};
						$allCount += $totalCount;
						if($totalCount!=0) {
							echo "共" . $totalCount . "個&nbsp;" . $temp . "(";
							if($a) { echo $a . "個正常"; echo ($b+$c)?",&nbsp":"";}
							if($b) { echo $b . "個加"; echo ($c)?",&nbsp;":""; }
							if($c) { echo $c . "個減"; }
							if($d) { echo $d . "個去冰"; echo ($e)?",&nbsp;":""; }
							if($e) { echo $e . "個少冰"; }
							echo ")" . "<br/>";
						};
					};
					if($people!="") { 
						$people=substr($people,'0','-1');
			?>
						<tr>
							<td bgColor="#FFFACD">
								<?php echo $temp."&nbsp;".$row4['foodPrice']."元"; ?>
							</td>
							<td bgColor="#FFFACD">
								<?php echo $people; ?>
							</td>
						</tr>
							
			<?php
					};
				};
				
				if($totalMoney!=0) {
					echo "共" . $allCount . "個,共<font size=\"5\" color=\"#0000FF\">" . $totalMoney . "</font>" . "元";
				};
			};
			?>
			
		</table>
		</br>
		<?php
			};
			if($num==0) { echo "今天還沒有人開團唷!考慮當一下主揪吧!";}
			
		}
		?>
		
		
		
	</body>
</html>