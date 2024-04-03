<?php
    require_once 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['員工id']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            $員工id = $_POST['員工id'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // 檢查兩次輸入的密碼是否相符
            if($new_password === $confirm_password) {
                // 更新資料庫中的密碼
                $sql = "UPDATE 醫療人員 SET password='$new_password', first_login=0 WHERE 員工id='$員工id'";
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