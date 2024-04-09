<?php
    session_start();
    $servername = "127.0.0.1";
    $username = "root";
    $password = "sinyu0306";
    $database = "Healper";

    $conn = new mysqli($servername, $username, $password, $database);

    // 檢查連接是否成功
    if (!$conn) {
        die("連接失敗: " . mysqli_connect_error());
    }

    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        $sql="SELECT 員工姓名 FROM 醫療人員 WHERE 員工id = '$username'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $員工姓名 = $row['員工姓名'];
        }
    } else {
        echo "請先登入！";
        exit;
    }   
    $error_msg = "";

    if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) {
        $search_keyword = $_GET['search_keyword'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <title>HEALPER</title> 
</head>

<body>
    <div class="container">
        <div class="sidebar">
        <?php
            if(isset($員工姓名)) {
                echo "<h2>" . $員工姓名 . "</h2>\n";
            }
            if(isset($username)) {
                echo "<h2>ID: " . $username . "</h2>";
            }
        ?>


            <div class="photo">
                <h3>photo</h3>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <h2>請輸入患者健保卡號或病歷號</h2>
            <div class="search-container">
                <form name="form" action="m-current.php" method="GET" accept-charset="UTF-8" align="center">
                    <div class="search-wrapper">
                        <input type="search" class="search-bar" name="search_keyword" placeholder="健保卡號或病歷號">
                        <button type="submit" class="search-button"> <img src="search.png" alt="Search"></button>
                    </div>
                </form>
                <?php
                    if(isset($error_msg)) {
                        echo "<p class='error'>$error_msg</p>";
                    }
                ?>
            </div> 
        </div>
    </div>
</body>
</html>
