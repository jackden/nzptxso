<?php
// 建立 MySQL 資料庫的連線
$connection = mysql_connect('localhost', 'sysop', 'sysop') or 
	trigger_error(mysql_error(), E_USER_ERROR);
// 設定在用戶端使用UTF-8的字元集
mysql_set_charset('utf8', $connection);
?>