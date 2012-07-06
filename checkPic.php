<?php require_once('Connections/connection.php'); ?>

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
//8位亂數密碼產生器
function generatorPassword($pt=8,$myWord=""){
    $password="";
    $str="0123456789abcdefghijklmnopqrstuvwxyz";
    $str.=$myWord;
    $str_len=strlen($str);
for ($i=1;$i<=$pt;$i++){
        $rg=rand()%$str_len;
        $password.=$str{$rg};
    }
return time().$password;
}
//避開強式密碼 < 在html消失
//header("Content-Type: text;"); 
 
/*
預設八個字元，設定10個字元
generatorPassword(10,<);
*/
	$Random = generatorPassword();
?>

<?php
	$shopName=$_POST['select1'];
	$temp=$_POST['select2'];
	
	//選取資料庫
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');
	
	$query = sprintf("SELECT foodName FROM menu WHERE id = '$temp' ");
    $result = mysql_query($query, $connection);
	if ($result) { $row = mysql_fetch_assoc($result); };
	$foodName = $row['foodName'];
	
	$filename = $_FILES["upfile"]["name"];
	$extend = strrchr($filename, ".");   //取得檔案的副檔名 abc.jpg 會成為 .jpg
	$imgsize = $_FILES["upfile"]["size"];
	$filetype = $_FILES['upfile']['type'];
	$filetemp = $_FILES["upfile"]["tmp_name"];
	$fname = $Random.$extend ;		     //目前時間.附檔名

	//開啟圖片檔
	$file = fopen($_FILES["upfile"]["tmp_name"], "rb");
	// 讀入圖片檔資料
	$fileContents = fread($file, filesize($_FILES["upfile"]["tmp_name"])); 
	
	//關閉圖片檔
	fclose($file);

	// 圖片檔案資料編碼
	$fileContents = base64_encode($fileContents);
	
	//組合查詢字串
	$query1 = "UPDATE menu SET filename = '$fname' , filesize = '$imgsize' , image = '$fileContents' , filetype = '$filetype' , userIp = '$userIp' WHERE shopName = '$shopName' AND foodName = '$foodName' ";
	$result1 = mysql_query($query1, $connection) or die(mysql_error());
	
	if ($result1) {
		// 回到前一個網頁 
		header('Location: index.php');
	}
?>