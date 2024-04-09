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

    /*if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
        header('Location: home.html');
        exit();
    }*/

    if(isset($_GET['card'])) {
        $card = $_GET['card'];
        $sql = "SELECT * FROM 使用者 WHERE 健保卡號 = '$card'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $使用者姓名 = $row['使用者姓名'];
            $id = $row["身分證字號"];
            $card = $row["健保卡號"];
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $出生日期 = $_POST['出生日期'];
        $性別 = $_POST['性別'];
        $手機號碼 = $_POST['手機號碼'];
        $地址 = $_POST['地址'];
        $緊急聯絡人姓名 = $_POST['緊急聯絡人姓名'];
        $親屬關係 = $_POST['親屬關係'];
        $緊急聯絡人電話 = $_POST['緊急聯絡人電話'];
        $緊急聯絡人電子郵件 = $_POST['緊急聯絡人電子郵件'];

        
        $update_sql = "UPDATE 使用者 SET 
                        出生日期='$出生日期', 
                        性別='$性別', 
                        手機號碼='$手機號碼', 
                        地址='$地址', 
                        緊急聯絡人姓名='$緊急聯絡人姓名', 
                        親屬關係='$親屬關係', 
                        緊急聯絡人電話='$緊急聯絡人電話', 
                        緊急聯絡人電子郵件='$緊急聯絡人電子郵件' 
                        WHERE 健保卡號='$_POST[card]'";

        if ($conn->query($update_sql) === TRUE) {
            header('Location: information.php?card='.$_POST['card']);
        } else {
            echo "更新失敗： " . $conn->error;
        }

        $conn->close();
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
        table {
            margin: 0 auto; /* 讓表格置中 */
        }
        h2#personal-info {
            margin-top: 10px; /* 調整修改個人資料文字與 HEALPER 之間的間隔 */
            margin-bottom: 10px;
        }
        th{
            text-align: right;
        }
        td{
            padding: 4px;
        }
        input[readonly] {
            background-color: #e6e6e6; /* 設置不可更改欄位的底色 */
            border: 1px solid #ccc; /* 加入灰色框線 */
            padding: 5px; /* 加入內間距 */
        }
        /* 加入底色 */
        input[type="text"],
        input[type="date"],
        input[type="password"] {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 5px;
        }
        /* 加入深色底色 */
        input[type="text"][readonly],
        input[type="date"][readonly],
        input[type="password"][readonly] {
            background-color: #d9d9d9;
            cursor: default;
        }

        /* 加入按鈕間距 */
        input[type="reset"],
        input[type="submit"] {
            margin-top: 10px;
            margin-right: 10px;
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
            <h2 id="personal-info">修改個人資料</h2>
            <div class="info-container">
                <form name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" accept-charset="UTF-8" align="center">
                <table height="4">
                        <tr>
                            <th align="left">使用者姓名：</th><td><input id="使用者姓名" type="text" name="使用者姓名" size="40" value="<?php echo $row['使用者姓名']; ?>" /> </td>
                        </tr>
                        <tr>
                            <th align="left">身分證字號：</th><td><input id="id" type="text" name="身分證字號" size="40" value="<?php echo $id;?>" readonly /> </td>
                        </tr>
                        <tr>
                            <th align="left">健保卡號：</th><td><input id="card" type="text" name="健保卡號" size="40" value="<?php echo $card;?>" readonly /> </td>
                        </tr>
                        <tr>
                            <th align="left">出生日期：</th><td><input id="出生日期" type="date" name="出生日期" value="<?php echo $row['出生日期']; ?>" /></td>
                        </tr>  
                        <tr>
                            <th align="left">性別：</th><td><input id="性別" type="text" name="性別" size="40" value="<?php echo $row['性別']; ?>"/></td>
                        </tr> 
                        <tr>
                            <th align="left">手機號碼：</th><td><input id="手機號碼" type="text" name="手機號碼" size="40" value="<?php echo $row['手機號碼']; ?>"/></td>
                        </tr> 
                        <tr>
                            <th align="left">地址：</th><td><input id="地址" type="text" name="地址" size="40" value="<?php echo $row['地址']; ?>"/></td>
                        </tr>
                        <tr>
                            <th align="left">緊急聯絡人姓名：</th><td><input id="緊急聯絡人姓名" type="text" name="緊急聯絡人姓名" size="40" value="<?php echo $row['緊急聯絡人姓名']; ?>"/></td> 
                        </tr>
                        <tr>
                            <th align="left">緊急聯絡人親屬關係：</th><td><input id="親屬關係" type="text" name="親屬關係" size="40" value="<?php echo $row['親屬關係']; ?>"/></td> 
                        </tr>
                        <tr>
                            <th align="left">緊急聯絡人電話：</th><td><input id="緊急聯絡人電話" type="text" name="緊急聯絡人電話" size="40" value="<?php echo $row['緊急聯絡人電話']; ?>"/></td> 
                        </tr>
                        <tr>
                            <th align="left">緊急聯絡人電子郵件：</th><td><input id="緊急聯絡人電子郵件" type="text" name="緊急聯絡人電子郵件" size="40" value="<?php echo $row['緊急聯絡人電子郵件']; ?>"/></td> 
                        </tr>
                    </table>
                    <input type="reset" value="重新填寫"/>
                    <input type="hidden" name="card" value="<?php echo $card; ?>">
                    <input type="submit" value="確認更新" />
                </form>
            </div>
        </div>
    </div>
</body>
</html>