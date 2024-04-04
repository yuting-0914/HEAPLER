<?php
// 處理登入和密碼更改的後端邏輯

// 建立與MySQL資料庫的連接
$servername = "127.0.0.1";
$username = "root";
$password = "sinyu0306";
$database = "Healper";

$conn = new mysqli($servername, $username, $password, $database);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 處理用戶登入
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 檢查用戶是否存在
    $sql = "SELECT * FROM 醫療人員 WHERE 員工id='$username' AND 密碼='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // 檢查是否為初次登入
        if ($row['初登入'] == 1) {
            // 導向用戶到密碼更改頁面
            header("Location: change_password.php?username=" . $username);
            exit();
        } else {
            // 登入成功，導向到應用程式的主頁面
            header("Location: home.php");
            exit();
        }
    } else {
        echo "無效的用戶名或密碼";
    }
}

// 關閉MySQL連接
$conn->close();
?>
