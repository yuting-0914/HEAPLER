<?php
    session_start();
    require_once 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $員工id = $_POST['員工id'];
        $密碼 = $_POST['密碼'];

        if(empty($員工id) || empty($密碼)){
            $_SESSION['error_message'] = "請正確輸入員工編號和密碼！";
            header('Location: m-home.html');
            exit();
        }

        $sql="SELECT * FROM 醫療人員 WHERE 員工id='$員工id' AND 密碼='$密碼'";
        // $result = $conn->query($sql);

        // 避免SQL注入問題
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $員工id, $密碼);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $_SESSION['is_login'] = TRUE;
            
            if ($row['first_login'] == 1) {
                // 導向用戶到密碼更改頁面
                header("Location: change_password.php?員工id=" . $員工id);
                exit();
            } else {
                
                $_SESSION['員工id']=$row['員工id'];
                $_SESSION['密碼']=$row['密碼'];
                header("Location: search.html");
                exit();
            }
        }
        else{
            $_SESSION['is_login'] = FALSE;
            $_SESSION['error_message'] = "員工編號或密碼輸入錯誤！";
            header('Location: m-shome.html');
            exit();
        }
    }
    else{
        $_SESSION['error_message'] = "請輸入員工編號和密碼！";
        header('Location: m-home.html');
        exit();
    }

    $conn->close();
?>