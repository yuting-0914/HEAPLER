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
            <div class="photo">
                <h3>photo</h3>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <h2>患者資訊</h2>
            <a href="current.html">
                <div class="patient-info">
                    <?php
                    require_once 'db_connect.php';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        //從POST中獲得搜尋欄輸入的資訊
                        $search_keyword = $_POST['search_keyword'];

                        $sql = "SELECT * FROM 使用者 WHERE 健保卡號='$search_keyword' OR 病例號='$search_keyword'";
                        $result = $conn->query($sql);

                        if ($result->num_rows == 1) {
                            while($row = $result->fetch_assoc()) {
                                echo "<div class='patient-box'>";
                                echo "<table>";
                                echo "<tr>";
                                echo "<th>姓名：</th><td>". $row["使用者姓名"]. "</td>";
                                echo "<th>病例號碼：</th><td>". $row["病例號"]. "</td>";
                                echo "<th>健保卡號：</th><td>". $row["健保卡號"]. "</td>";
                                echo "</tr>";
                                echo "</table>";
                                echo "</div>";
                            }
                        } else {
                            echo "查無患者資訊";
                        }
                    }
                    $conn->close();
                    ?>
                </div>
            </a>
        </div>
    </div>
</body>

</html>
