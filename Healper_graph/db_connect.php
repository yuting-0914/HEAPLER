<?php
// 定義資料庫連線參數
$servername = "localhost";
$username = "root";
$password = "sinyu0306";
$database = "Healper";

// 建立與 MySQL 資料庫的連線
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連線是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
?>
