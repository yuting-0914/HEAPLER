<?php
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['username']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            $員工id = $_POST['username'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // 檢查兩次輸入的密碼是否相符
            if($new_password === $confirm_password) {
                // 更新資料庫中的密碼
                $sql = "UPDATE 醫療人員 SET 密碼='$new_password', 初登入=0 WHERE 員工id='$username'";
                if ($conn->query($sql) === TRUE) {
                    echo "密碼更新成功";
                } else {
                    echo "密碼更新失敗: " . $conn->error;
                }
            } else {
                echo "新密碼與確認密碼不相符";
            }
        } else {
            echo "請提供所有必要的資料";
        }
    } else {
        echo "請通過正確的表單提交方式訪問此頁面";
    }

    $conn->close();
?>