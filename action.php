<?php require_once('Connections/connection.php'); ?>

<?php

    // 選擇 MySQL 資料庫lunch
	mysql_select_db('lunch', $connection) or die('資料庫lunch不存在');

    // 預設選項
    $data['0'] = '請選擇';

    // 只有在 shopName 存在的情況下，才進行資料庫的搜尋
    if (0 !== $_GET['id']) {
        $shopName = $_GET['id'];
        
        $query = sprintf("SELECT id, foodName FROM menu WHERE shopName = '$shopName' ");
        $result = mysql_query($query, $connection);
        while ($row = mysql_fetch_assoc($result)) {
        
            // 將取得的資料放入陣列中
            $data[$row['id']] = $row['foodName'];
        }
    }
    // 將陣列轉換為 json 格式輸入
    echo json_encode($data);