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
    $username = $_POST['username'];
    $password = $_POST['password'];

if(empty($username) || empty($password)){
    $_SESSION['error_message'] = "請正確輸入員工編號和密碼！";
    header('Location: m-home.html');
    exit();
}


    $sql="SELECT * FROM 醫療人員 WHERE 員工id='$username' AND 密碼='$password'";
    $result = $conn->query($sql);

    // 避免SQL注入問題
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();        
        if ($row['初登入'] == 1) {
            // 導向用戶到密碼更改頁面
            header("Location: change_pwd.php?username=" . $username);
            exit();
        } else {
            
            $_SESSION['username']=$row['username'];
            $_SESSION['password']=$row['password'];
            header("Location: search.html");
            exit();
        }
    } else{
        $_SESSION['is_login'] = FALSE;
        $_SESSION['error_message'] = "員工編號或密碼輸入錯誤！";
        header('Location: m-home.html');
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