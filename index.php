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
	//$now=date("H:i:s");
	$now=date("H:i");
?>

<?php
//**********************************//
// 在lunchGroup資料表內插入一筆新的紀錄
//**********************************//
if ((isset($_POST["insert"])) && ($_POST["insert"] == "create")) 
{
	// 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	// 在lunchGroup資料表內插入一筆新的紀錄
	$query = sprintf("INSERT INTO lunchGroup (primaryName, shopName, orderDate, userIp, overTime) 
	VALUES (%s, %s, %s, %s, %s)", 
	GetSQLValue($_POST['primaryName'], "text"), GetSQLValue($_POST['create_shopName'], "text"),
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

<?php
//**********************************//
// 在shop資料表內插入一筆新的紀錄
//**********************************//
if ((isset($_POST["insert"])) && ($_POST["insert"] == "add_shop")) 
{
	// 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	// 在shop資料表內插入一筆新的紀錄
	$query = sprintf("INSERT INTO shop (shopName, shopPhone, deliveryCondition, userIp) 
	VALUES (%s, %s, %s, %s)", 
	GetSQLValue($_POST['add_shopName'], "text"), GetSQLValue($_POST['shopPhone'], "text"),
	GetSQLValue($_POST['deliveryCondition'], "text"), GetSQLValue($userIp, "text") );
		
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
		<title>訂午餐系統</title>
		
		<script type="text/javascript" src="JavaScript/ellipsis.js"></script>
		
		<style>
			.main_table {  
			  border: 1px solid #000000;  
			  border-collapse: collapse;  
			}  
			.main_tr, .main_td {  
			  border: 1px solid #000000;  
			}
			
			.ellipsis {
				display: block; /* or inline-block 必須是 block 或 inline-block*/
				white-space: nowrap;
				overflow: hidden;
				-o-text-overflow: ellipsis;    /* Opera */
				text-overflow:    ellipsis;    /* IE, Safari (WebKit) */
			}
			
			.tc_box{
				position:absolute; 
				z-index:2000; 
				background:#FFF;  
				display:none; 
			}
			
			.sp_box{ 
				width:100%;  
				position:absolute; 
				z-index:1000; 
				background:#000; 
				top:0; 
				left:0; 
				display:none; 
			}
			
			.titleBar{
				background:#3B5998;
				border-bottom: 1px solid #133783;
			}
		</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="selectbox/selectboxes.js"></script>
<script type="text/javascript" src="selectbox/index.js"></script>
<script src="JavaScript/create.js" type="text/javascript"></script>
<script src="JavaScript/shop.js" type="text/javascript"></script>
<script src="JavaScript/upload.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$("#create_button").click(function(){//點擊“點我彈出層”時候
		var top_layer="#create";
		var bottom_layer=".sp_box";
		$(top_layer).fadeIn(1000).show();//彈出提示層，之前是隱藏在body裏面的
		var sp_height = $(document).height();//獲取當期窗口的高度
		$(bottom_layer).css({"opacity":"0.5","height":sp_height});//鎖屏層高度採用獲取窗口的高度，從而達到鎖全屏的目的。
		$(bottom_layer).show();//顯示鎖屏層，此時鎖屏層的寬在CSS裏設置了100%
		fixScreen(top_layer);
	});
	
	$("#add_shop_button").click(function(){//點擊“點我彈出層”時候
		var top_layer="#add_shop";
		var bottom_layer="#create";
		$(top_layer).fadeIn(1000).show();//彈出提示層，之前是隱藏在body裏面的
		var sp_height = $(document).height();//獲取當期窗口的高度
		$(bottom_layer).css({"opacity":"0.5"});//鎖屏層高度採用獲取窗口的高度，從而達到鎖全屏的目的。
		$(bottom_layer).show();//顯示鎖屏層，此時鎖屏層的寬在CSS裏設置了100%
		fixScreen(top_layer);
	});
	
	$("#upload_button").click(function(){//點擊“點我彈出層”時候
		var top_layer="#upload";
		var bottom_layer=".sp_box";
		$(top_layer).fadeIn(1000).show();//彈出提示層，之前是隱藏在body裏面的
		var sp_height = $(document).height();//獲取當期窗口的高度
		$(bottom_layer).css({"opacity":"0.5","height":sp_height});//鎖屏層高度採用獲取窗口的高度，從而達到鎖全屏的目的。
		$(bottom_layer).show();//顯示鎖屏層，此時鎖屏層的寬在CSS裏設置了100%
		fixScreen(top_layer);
	});
	
	$(".close_all").click(function(){//點擊關閉時候
		$(".tc_box").hide();//彈出提示層消失
		$(".sp_box").hide();//鎖屏層消失
	});
	
	$(".close_one").click(function(){//點擊關閉時候
		var top_layer="#add_shop";
		var bottom_layer="#create";
		$(top_layer).hide();//彈出提示層消失
		$(bottom_layer).css({"opacity":"1"});//鎖屏層高度採用獲取窗口的高度，從而達到鎖全屏的目的。
		$(bottom_layer).fadeIn(1000).show();//顯示鎖屏層，此時鎖屏層的寬在CSS裏設置了100%
	});
	
});

function fixScreen(layer) {
	var screenwidth,screenheight,popupHeight,popupWidth,mytop,getPosLeft,getPosTop;
	screenwidth = $(window).width();
	screenheight = $(window).height();
	popupHeight = $(layer).height();
	popupWidth = $(layer).width();
	mytop = $(document).scrollTop();
	getPosLeft = screenwidth/2 - popupWidth/2;
	getPosTop = screenheight/2 - popupHeight/2;
	$(layer).css({"left":getPosLeft,"top":getPosTop});
	
	$(window).resize(function(){
		mytop = $(document).scrollTop();
		$(layer).css({"left":getPosLeft,"top":getPosTop+mytop});
	});
	
	$(window).scroll(function(){
		mytop = $(document).scrollTop();
		$(layer).css({"left":getPosLeft,"top":getPosTop+mytop});
	});
}
</script>
	</head>

	
	
	<body>
		<input id="create_button" type="button" value="我要當主揪">
		<br/><br/>
		<input id="upload_button" type="button" value="上傳菜單照片">
		<br/><br/>
		<!--- <font size="5px" color="FF0000">聲明:請各位資網中心的高手不要攻擊我的網站，小的能力淺薄，這是方便大家訂餐的簡單網頁而已，還請各位高抬貴手</font>
		<br/><br/> --->
		<br/><br/>
		<div style="float:left;width:45%">
		<h2><?php echo $today ?>的團購</h2>
		<br/>
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
		<table class="main_table">
			<tr  class="main_tr">
				<td class="main_td">
					<a href="list.php?groupId=<?php echo $row['id'] ?>"><?php echo $row['primaryName'] . "的團" ?></a>
				</td>
				<td class="main_td">
					<?php echo "今天中午訂" . "<font size=\"5\" color=\"FF0000\">" . $row['shopName'] . "</font>"; $shopName=$row['shopName']; ?>
				</td>
				<?php
					if($userlevel==1) {
				?>
					<td class="main_td">
						<input type="button" value="X" onclick="self.location.href='delete.php?groupId=<?php echo $row['id'] ?>&userlevel=2'">
					</td>
				<?php
					};
				?>
			</tr>
			<tr class="main_tr">
				<?php
					$overTime=explode(":",$row['overTime']);
					$nowTime=explode(":",$now);
					
					if( ($nowTime[0]<$overTime[0]) || ($nowTime[0]==$overTime[0] && $nowTime[1]<$overTime[1]) ) {
				?>
					<td class="main_td">
						<a href="order.php?groupId=<?php echo $row['id'] ?>">我要訂購</a><br/>
						結團時間為<?php echo $row['overTime'] ?>
					</td>
				<?php
					}
					else {
				?>
					<td class="main_td">
						訂購時間已過<br/>
						結團時間為<?php echo $row['overTime'] ?>
					</td>
				<?php
					}
					
				?>
				<td class="main_td">
					<?php
					$query5 = "SELECT shopPhone,deliveryCondition FROM shop WHERE shopName = '$shopName'";
					// 傳回結果集
					$result5 = mysql_query($query5, $connection) or die(mysql_error());
					if ($result5) { $row5 = mysql_fetch_assoc($result5); }
					echo "電話:" . "<font size=\"4\" color=\"FF0FFF\">" . $row5['shopPhone'] . "</font>";
					
					if($row5['deliveryCondition'])
					{
						echo "<br/>外送條件:"."<font size=\"4\" color=\"#228B22\">".$row5['deliveryCondition']. "</font>";
					};
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
						<tr  class="main_tr">
							<td bgColor="#E6E6FA" class="main_td">
								<?php 
									$temp1=$row1['foodName'];
									echo $row1['userName'] . "&nbsp;" . $row1['foodCount'] . "個&nbsp;" . $row1['foodName'];
									if($row1['userRemark']=="加") { echo "&nbsp;加"; }
									if($row1['userRemark']=="減") { echo "&nbsp;減"; }
									if($row1['userRemark']=="去冰") { echo "&nbsp;去冰"; }
									if($row1['userRemark']=="少冰") { echo "&nbsp;少冰"; }
									echo "&nbsp;<font size=\"4\" color=\"#FF4500\">".$row1['userRemark1']."</font>";
								?>
							</td>
							<td bgColor="#E6E6FA" class="main_td">
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
								<td class="main_td">
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
								if($row3['userRemark']=="加") { $b += $row3['foodCount']; };
								if($row3['userRemark']=="減") { $c += $row3['foodCount']; };
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
						<tr class="main_tr">
							<td bgColor="#FFFACD" class="main_td">
								<?php echo $temp."&nbsp;".$row4['foodPrice']."元"; ?>
							</td>
							<td bgColor="#FFFACD" class="main_td">
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
		<br/>
		<?php
			};
			if($num==0) { echo "今天還沒有人開團唷!考慮當一下主揪吧!";}
			
		}
		?>
	</div>
	
	<div style="float:right;width:45%">
		<h2>更新紀錄</h2>
		<p style="text-align:right;"><a href="changelog.php">所有紀錄…</a></p>
		
		<ul>
		<?php
			$query7 = "SELECT * FROM changeLog order by changeDate DESC limit 0,10"; 
			// 傳回結果集
			$result7 = mysql_query($query7, $connection) or die(mysql_error());
			$num7=mysql_num_rows($result7);
			if ($result7) {
				while ( $row7 = mysql_fetch_assoc($result7) ) {
		?>
		
			<li class="ellipsis">
				<span><?php echo $row7['changeDate']; ?></span>
				<span><?php echo $row7['changeContent']; ?></span>
			</li>
		<?php
				}
			}
		?>
		</ul>
	</div>
	
	<div id="create" class="tc_box">
		<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
			<div class="titleBar">
				<div style="float:left; color:#FFF;"><b>開團</b></div>
				<div style="text-align:right;"><a href="#" role="button"><b class="close_all" style="color:#FFF;" title="關閉">X</b></a></div>
			</div>
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
						<input id="add_shop_button" type="button" value="新增店家">
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
								<input type="radio" id="create_shopName" name="create_shopName" value="<?php echo $row['shopName'] ?>"><label><?php echo $row['shopName'] ."&nbsp; 電話:" . "<font size=\"4\" color=\"FF0FFF\">" . $row['shopPhone'] . "</font>" . "&nbsp; 外送條件:"."<font size=\"4\" color=\"#228B22\">".$row5['deliveryCondition']. "</font>"; ?></label>
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
					<td><input id="send" name="submit" type="submit" value="送出" onclick="return CheckCreate();" /></td>
				</tr>
			</table>
			<input name="insert" id="insert" type="hidden" value="create" />
		</form>
	</div>
	
	<div id="add_shop" class="tc_box">
		<form method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
			<div class="titleBar">
				<div style="float:left; color:#FFF;"><b>新增店家</b></div>
				<div style="text-align:right;"><a href="#" role="button"><b class="close_one" style="color:#FFF;" title="關閉">X</b></a></div>
			</div>
			<table>
				<tr>
					<td><center>店家名稱:</center></td>
					<td><input name="add_shopName" id="add_shopName" type="text" maxlength="30" size="25" /></td>
				</tr>
				<tr>
					<td><center>店家電話:</center></td>
					<td><input name="shopPhone" id="shopPhone" type="text" maxlength="30" size="25" /></td>
				</tr>
				<tr>
					<td><center>外送條件:</center></td>
					<td><input name="deliveryCondition" id="deliveryCondition" type="text" maxlength="30" size="25" /></td>
				</tr>
				
				
				<tr>
					<td><input id="send" name="submit" type="submit" value="送出" onclick="return CheckFields();" /></td>
				</tr>
			</table>
			<input name="insert" id="insert" type="hidden" value="add_shop" />
		</form>
	</div>
	
	<div id="upload" class="tc_box">
	<form method="post" enctype="multipart/form-data" action="checkPic.php">
		<div class="titleBar">
			<div style="float:left; color:#FFF;"><b>上傳照片</b></div>
			<div style="text-align:right;"><a href="#" role="button"><b class="close_all" style="color:#FFF;" title="關閉">X</b></a></div>
		</div>
		<div>
			<p>
				店家名稱:
				<?php
					mysql_select_db('lunch', $connection) or die('資料庫lunch不存在'); 
					
					$query = "SELECT * FROM shop"; 
					// 傳回結果集
					$result = mysql_query($query, $connection) or die(mysql_error());
				?>
				
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
			</p>
		
			<p>
				菜單:
				
				<select id="select2" name="select2">
					<option value="0">請選擇</option>
				</select>
			
				<Input type="File" id="upfile" name="upfile" ><br>
			</p>
		
			<input id="send" name="submit" type="submit" value="開始上傳" onclick="return CheckUpload();" />
		

			<input name="insert" id="insert" type="hidden" value="upload" />
		</div>
	</form>
		</div>
		<div class="sp_box"></div>
		
		
	</body>
</html>