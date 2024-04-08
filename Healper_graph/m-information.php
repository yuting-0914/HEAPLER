<?php
    session_start();
    require_once 'db_connect.php';

    if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) {
        $search_keyword = $_GET['search_keyword'];

        $sql="SELECT * FROM 使用者 WHERE 健保卡號 = '$search_keyword' OR 病歷號='$search_keyword'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $使用者姓名 = $row['使用者姓名'];
            $card = $row["健保卡號"];
            $病歷號 = $row['病歷號'];
            $id = $row["身分證字號"];
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
</style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <?php
                if(isset($使用者姓名)) {
                    echo "<h2>" . $使用者姓名 . "</h2>";
                    echo "<a href='m-current.php?search_keyword=$search_keyword' class='profile-button'>數據資料</a>";
                }
            ?>
            <div class="photo">
                <h3>photo</h3>
            </div>
            <div class="medical-profile">
                <div class="medical-photo">
                    <h5>photo</h5>
                </div>
                <div class="medical-data">
                    <?php
                    if(isset($員工姓名)) {
                        echo "<p>" . $員工姓名 . "</p>";
                    }
                    if(isset($_SESSION['username'])) {
                        echo "<p> ID:" . $username . "</p>";
                    }
                    ?>
                    <a href="search.php" class="medical-profile-button">個人主頁</a>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
                <?php
                    if(isset($使用者姓名)) {
                        echo "<div class='info-container'>";
                        echo "<h2 id='personal-info'>患者資料</h2>";
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
        </div>
    </div>
</body>
</html>