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


    /*if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
        header('Location: home.html');
        exit();
    } */

    //$sql = ' '; // 初始化 $sql 變數

    if (isset($_GET['card']) && !empty($_GET['card'])) {
        $card = $_GET['card'];
        
        $sql = "SELECT * FROM 使用者 WHERE 健保卡號 = '$card'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $使用者姓名 = $row['使用者姓名'];
            $id = $row["身分證字號"];
            $card = $row["健保卡號"];
            $出生日期 = $row["出生日期"];
            $性別 = $row["性別"];
            $手機號碼 = $row["手機號碼"];
            $地址 = $row["地址"];
            $緊急聯絡人姓名 = $row["緊急聯絡人姓名"];                        
            $親屬關係 = $row["親屬關係"];                        
            $緊急聯絡人電話 = $row["緊急聯絡人電話"];                        
            $緊急聯絡人電子郵件 = $row["緊急聯絡人電子郵件"];
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <title>HEALPER</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            position: relative;
        }
        .content {
            text-align: center;
        }
        table {
            width: auto; /* 調整表格寬度 */
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
        }
        th {
            padding: 4px 8px; /* 調整 th 的 padding */
            text-align: right;
            border-bottom: 1px solid #ddd;
            background-color: #f2f2f2;
        }
        td {
            padding: 4px; /* 調整 td 的 padding */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        h2#personal-info {
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .info-container {
            margin-bottom: 20px;
        }
        .profile-button {
            display: flex;
            width: 10vw;
            height: 3vh;
            background-color: white;
            padding: 8px;
            border-radius: 30px;
            color: rgb(0, 0, 0);
            font-family: "微軟正黑體";
            text-align: center;
            text-decoration: none;
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            align-items: center;
            justify-content: center;
        }
        .update-button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 5px 10px;
            background-color: #2C5C84;
            color: white;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .update-button:hover {
            background-color: #808080;
        }
        .update-container{
            position: absolute;
            top: 490px;
            right: 530px;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="sidebar">
            <?php
                if(isset($使用者姓名)) {
                    echo "<h2>" . $使用者姓名 . "</h2>";
                    echo "<a href='current.php?card=$card' class='profile-button'>數據資料</a>";
                }
            ?>

            <div class="photo">
                <h3>photo</h3>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <?php
                if(isset($使用者姓名)) {
                    echo "<div class='info-container'>";
                    echo "<h2 id='personal-info'>個人資料</h2>";
                    echo "<table>";
                    echo "<tr><th>姓名：</th><td>". $使用者姓名 . "</td></tr>";
                    echo "<tr><th>身分證字號：</th><td>". $id . "</td></tr>";
                    echo "<tr><th>健保卡號：</th><td>". $card . "</td></tr>";
                    echo "<tr><th>出生日期：</th><td>". $出生日期 . "</td></tr>";
                    echo "<tr><th>性別：</th><td>". $性別 . "</td></tr>";
                    echo "<tr><th>手機號碼：</th><td>". $手機號碼 . "</td></tr>";
                    echo "<tr><th>地址：</th><td>". $地址 . "</td></tr>";
                    echo "<tr><th>緊急聯絡人姓名：</th><td>". $緊急聯絡人姓名 . "</td></tr>";                        
                    echo "<tr><th>親屬關係：</th><td>". $親屬關係 . "</td></tr>";                        
                    echo "<tr><th>緊急聯絡人電話：</th><td>". $緊急聯絡人電話 . "</td></tr>";                        
                    echo "<tr><th>緊急聯絡人電子郵件：</th><td>". $緊急聯絡人電子郵件 . "</td></tr>";
                    echo "</table>";
                    echo "</div>";
                }
            ?>
        </div>
        <div class="update-container">
            <?php
                if(isset($使用者姓名)) {
                    echo "<div class='info-container'>";
                    echo "<a href='information_update.php?card=$card' class='update-button'>修改資料</a>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</body>

</html>
