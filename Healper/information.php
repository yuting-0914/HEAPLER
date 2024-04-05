<?php
    session_start();
    require_once 'db_connect.php';

    if(isset($_GET['健保卡號']) && !empty($_GET['健保卡號'])) {
        $健保卡號 = $_GET['健保卡號'];

        $sql="SELECT * FROM 使用者 WHERE 健保卡號 = '$健保卡號'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $使用者姓名 = $row['使用者姓名'];
            $身分證字號 = $row["身分證字號"];
            $健保卡號 = $row["健保卡號"];
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
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <!-- <h2>Name</h2>
            <a href="" class="profile-button">數據資料</a> -->
            <?php
                if(isset($使用者姓名)) {
                    echo "<h2>使用者姓名：" . $使用者姓名 . "</h2>";
                    echo "<a href='m-current.php?健保卡號=$健保卡號' class='profile-button'>數據資料</a>";
                }
            ?>
            <div class="photo">
                <h3>photo</h3>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <h2 id="personal-info">個人資料</h2>
            <div class="info-container">

                <?php
                    if(isset($使用者姓名)) {
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>姓名：</th><td>". $使用者姓名 . "</td>";
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
                    //             FROM dbo.使用者 WHERE 健保卡號 = '$健保卡號'";
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
                ?>

                <form name="form" action="information_update.php" method="POST" accept-charset="UTF-8" align="center">
                    <input type="hidden" name="健保卡號" value="<?php echo $健保卡號; ?>">
                    <input type="submit" value="確認送出" />
                </form>
                <!-- <a href="information_update.php?modify=true">修改資料</a> -->

            </div> 
        </div>
    </div>
</body>
</html>