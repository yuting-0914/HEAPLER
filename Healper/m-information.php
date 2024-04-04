<?php
    session_start();
    require_once 'db_connect.php';

    if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) {
        $search_keyword = $_GET['search_keyword'];

        $sql="SELECT * FROM 使用者 WHERE 健保卡號 = '$search_keyword' OR 病例號='$search_keyword'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $使用者姓名 = $row['使用者姓名'];
            $健保卡號 = $row["健保卡號"];
            $病例號 = $row['病例號'];
            $身分證字號 = $row["身分證字號"];
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

    if(isset($_SESSION['員工id'])) {
        $員工id = $_SESSION['員工id'];

        $sql="SELECT 員工姓名 FROM 醫療人員 WHERE 員工id = '$員工id'";
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
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <!-- <h2>Name</h2> -->
            <!-- <a href="" class="profile-button">數據資料</a> -->
            <?php
                if(isset($使用者姓名)) {
                    echo "<h2>使用者姓名：" . $使用者姓名 . "</h2>";
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
                            echo "<p>" . $員工姓名 . "</h2>";
                            echo "<p>ID:" . $員工id . "</h2>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <h2 id="personal-info">患者資料</h2>
            <div class="info-container">
                <?php
                    if(isset($使用者姓名)) {
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>姓名：</th><td>". $使用者姓名 . "</td>";
                        echo "<th>病例號：</th><td>". $病例號 . "</td>";
                        echo "<th>身分證字號：</th><td>". $身分證字號 . "</td>";
                        echo "<th>健保卡號：</th><td>". $健保卡號 . "</td>";
                        echo "<th>出生日期：</th><td>". $出生日期 . "</td>";
                        echo "<th>性別：</th><td>". $性別 . "</td>";
                        echo "<th>手機號碼：</th><td>". $手機號碼 . "</td>";
                        echo "<th>地址：</th><td>". $地址 . "</td>";
                        echo "<th>緊急聯絡人姓名：</th><td>". $緊急聯絡人姓名 . "</td>";                        
                        echo "<th>親屬關係：</th><td>". $親屬關係 . "</td>";                        
                        echo "<th>緊急聯絡人電話：</th><td>". $緊急聯絡人電話 . "</td>";                        
                        echo "<th>緊急聯絡人電子郵件：</th><td>". $緊急聯絡人電子郵件 . "</td>";
                        echo "</tr>";
                        echo "</table>";
                    }

                    // require_once 'db_connect.php';

                    // if($_POST['健保卡號']!=''){
                    //     $健保卡號=$_POST['健保卡號'];
                    //     $sql="SELECT 健保卡號,使用者姓名,身分證字號,病例號,出生日期,性別,手機號碼,
                    //                     地址,緊急聯絡人姓名,親屬關係,緊急聯絡人電話,緊急聯絡人電子郵件
                    //             FROM 使用者 WHERE 健保卡號 = '$健保卡號'";
                    // }

                    // $result = $conn->query($sql);
                    // while($row = $result->fetch_assoc()) {

                    //     echo "<table>";
                    //     echo "<tr>";
                    //     echo "<th>姓名：</th><td>". $row["使用者姓名"]. "</td>";
                    //     echo "<th>身分證字號：</th><td>". $row["身分證字號"]. "</td>";
                    //     echo "<th>健保卡號：</th><td>". $row["健保卡號"]. "</td>";
                    //     echo "<th>出生日期：</th><td>". $row["出生日期"]. "</td>";
                    //     echo "<th>性別：</th><td>". $row["性別"]. "</td>";
                    //     echo "<th>手機號碼：</th><td>". $row["手機號碼"]. "</td>";
                    //     echo "<th>地址：</th><td>". $row["地址"]. "</td>";
                    //     echo "<th>緊急聯絡人姓名：</th><td>". $row["緊急聯絡人姓名"]. "</td>";                        
                    //     echo "<th>親屬關係：</th><td>". $row["親屬關係"]. "</td>";                        
                    //     echo "<th>緊急聯絡人電話：</th><td>". $row["緊急聯絡人電話"]. "</td>";                        
                    //     echo "<th>緊急聯絡人電子郵件：</th><td>". $row["緊急聯絡人電子郵件"]. "</td>";
                    //     echo "</tr>";
                    //     echo "</table>";
                    // }
                ?>

                <!-- <form name="form" action="http://127.0.0.1:8080/Healper/information_data.php" method="POST" accept-charset="UTF-8" align="center">
                    <input id="modify" name="modify" type="submit" value="修改資料" />
                </form> -->
                <a href="http://127.0.0.1:8080/Healper/information_update.php?modify=true">修改資料</a>

            </div> 
        </div>
    </div>
</body>
</html>