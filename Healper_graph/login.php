<?php
    session_start();
    require_once 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $身分證字號 = $_POST['身分證字號'];
        $健保卡號 = $_POST['健保卡號'];

        if(empty($身分證字號) || empty($健保卡號)){
            $_SESSION['error_message'] = "請輸入身分證字號和健保卡號！";
            header('Location: home.html');
            exit();
        }

        $sql="SELECT * FROM 使用者 WHERE 身分證字號='$身分證字號' && 健保卡號='$健保卡號'";
        // $result = $conn->query($sql);

        // 避免SQL注入問題
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $身分證字號, $健保卡號);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $_SESSION['is_login'] = TRUE;
            
            $row = $result->fetch_assoc();
            $_SESSION['身分證字號']=$row['身分證字號'];
            $_SESSION['健保卡號']=$row['健保卡號'];
            header('Location: current.html');
            exit();
        }
        else{
            $_SESSION['is_login'] = FALSE;
            $_SESSION['error_message'] = "身分證字號或健保卡號輸入錯誤！";
            header('Location: home.html');
            exit();
        }
    }
    else{
        $_SESSION['error_message'] = "請輸入帳號或密碼！";
        header('Location: home.html');
        exit();
    }

$conn->close();
?>