<?php
    session_start();
    require_once 'db_connect.php';

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
            <?php
                if(isset($員工姓名)) {
                    echo "<h2>" . $員工姓名 . "</h2>";
                }
            ?>
            <div class="photo">
                <h3>photo</h3>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <h2>患者資訊</h2>
            <?php
                require_once 'db_connect.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //從POST中獲得搜尋欄輸入的資訊
                    $search_keyword = $_POST['search_keyword'];

                    $sql = "SELECT * FROM 使用者 WHERE 健保卡號='$search_keyword' OR 病例號='$search_keyword'";
                    $result = $conn->query($sql);

                    if ($result->num_rows == 1) {
                        while($row = $result->fetch_assoc()) {
                            echo "<a href='m-current.php?search_keyword=$search_keyword'>";
                            echo "<div class='patient-info'>";
                            echo "<table>";
                            echo "<tr>";
                            echo "<th>姓名：</th><td>". $row["使用者姓名"]. "</td>";
                            echo "<th>病例號碼：</th><td>". $row["病例號"]. "</td>";
                            echo "<th>健保卡號：</th><td>". $row["健保卡號"]. "</td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "</div>";
                            echo "</a>";
                        }
                    } else {
                        echo "查無患者資訊";
                    }
                }
                $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
