<?php
header("Content-Type:text/html; charset=UTF-8");
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
            <h2>Name</h2>
            <a href="" class="profile-button">數據資料</a>
            <div class="photo">
                <h3>photo</h3>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <h2 id="personal-info">個人資料</h2>
            <div class="info-container">

                <?php
                    require_once 'db_connect.php';

                    if($_POST['健保卡號']!=''){
                        $健保卡號=$_POST['健保卡號'];
                        $sql="SELECT 健保卡號,使用者姓名,身分證字號,病歷號,出生日期,性別,手機號碼,
                                        地址,緊急聯絡人姓名,親屬關係,緊急聯絡人電話,緊急聯絡人電子郵件
                                FROM 使用者 WHERE 健保卡號 = '$健保卡號'";
                    }
                    // else{
                    //     $sql="SELECT * FROM dbo.使用者 ";
                    // }

                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {

                        echo "
                        使用者姓名：".$row['使用者姓名']."<br/>
                        身分證字號：".$row['身分證字號']."<br/>
                        健保卡號：".$row['健保卡號']."<br/>
                        病歷號：".$row['病例號']."<br/>
                        出生日期：".$row['出生日期']."<br/>
                        性別：".$row['性別']."<br/>
                        手機號碼：".$row['手機號碼']."<br/>
                        地址：".$row['地址']."<br/>
                        緊急聯絡人姓名：".$row['緊急聯絡人姓名']."<br/>
                        親屬關係：".$row['親屬關係']."<br/>
                        緊急聯絡人電話：".$row['緊急聯絡人電話']."<br/>
                        緊急聯絡人電子郵件：".$row['緊急聯絡人電子郵件']."<br/>";
                    }
                ?>

                <!-- <form name="form" action="http://127.0.0.1:8080/Healper/information_data.php" method="POST" accept-charset="UTF-8" align="center">
                    <input id="modify" name="modify" type="submit" value="修改資料" />
                </form> -->
                <a href="information_update.php?modify=true">修改資料</a>

            </div> 
        </div>
    </div>
</body>
</html>