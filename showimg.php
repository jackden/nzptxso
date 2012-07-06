<?
$filename=$_GET['filename'];

 $dbnum=mysql_connect("localhost","sysop","sysop");
 //選取資料庫
 mysql_select_db("lunch");
 //組合查詢字串
 $SQLSTR="select image,filetype from menu where filename='$filename'";
 //
 $cur=mysql_query($SQLSTR);
 //取出資料
 $data=mysql_fetch_array( $cur );

//設定網頁資料格式
header("Content-Type: $data[1]");

// 輸出圖片資料
$img1 = base64_decode($data[0]);

echo $img1;

?>