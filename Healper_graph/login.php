<?php
session_start();
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
    $id = $_POST['id'];
    $card = $_POST['card'];

if(empty($id) || empty($card)){
    $_SESSION['error_message'] = "請輸入身分證字號和健保卡號！";
    header('Location: home.html');
    exit();
}

    $sql="SELECT * FROM 使用者 WHERE 身分證字號='$id' AND 健保卡號='$card'";
    $result = $conn->query($sql);

    /*// 避免SQL注入問題
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $身分證字號, $健保卡號);
    $stmt->execute();
    $result = $stmt->get_result();
    */
    if ($result->num_rows == 1) {
        $_SESSION['is_login'] = TRUE;
        $_SESSION['身分證字號']= $id;
        $_SESSION['健保卡號']= $card;
        header('Location: current.html');
        exit();
    }else{
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