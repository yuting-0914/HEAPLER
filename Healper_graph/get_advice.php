<?php
    session_start();

    // 建立與資料庫的連接
    $servername = "127.0.0.1";
    $username = "root";
    $password = "sinyu0306";
    $database = "Healper";

    $conn = new mysqli($servername, $username, $password, $database);
    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    if(isset($_GET['status'])) {
        $status = $_GET['status'];
        $sql = "SELECT 衛教建議 FROM 衛教建議 WHERE 狀態 = '$status'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $suggestion = $row['衛教建議'];
            echo '溫馨提醒：';
            echo $suggestion; 
        }
    }
    
?>
