<?php
    // 資料庫連接
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

    // 確保使用者已登入
    if(!isset($_SESSION['username'])) {
        echo "請先登入！";
        exit;
    } 

    // 確認是否有搜尋到患者資料
    if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) {
        $search_keyword = $_GET['search_keyword'];

        $sql = "SELECT 使用者姓名 FROM 使用者 WHERE 健保卡號 = '$search_keyword' OR 病歷號='$search_keyword'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $使用者姓名 = $row['使用者姓名'];
        } else {
            echo "找不到相應的患者資料";
            exit;
        }
    }else{
        echo "請輸入資料";
        exit;
    }

    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    
        $sql="SELECT 員工姓名 FROM 醫療人員 WHERE 員工id = '$username'";
        $result = $conn->query($sql);
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $員工姓名 = $row['員工姓名'];
        }
    }
    // 構建current.php頁面的URL
    $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-database-compat.js"></script>
    <script type="module" src="test.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCaDAfZPctTUNxJx6mxCVbTdXd38exVRYk&callback=initialize" async defer></script>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <title>HEALPER</title>
</head>

<script>
    window.lat = 37.7850;
    window.lng = -122.4383;

    var map;
    var mark;
    var lineCoords = [];

    var initialize = function() {
        map = new google.maps.Map(document.getElementById('map-canvas'), {center:{lat:lat,lng:lng},zoom:12});
        mark = new google.maps.Marker({position:{lat:lat, lng:lng}, map:map});
    };

    const FirebaseConfig = {
            apiKey: "AIzaSyDAdJsgmpxoRN4aqg5vwEyliA6Zi5PBH3w",
            authDomain: "gps-traker-4de59.firebaseapp.com",
            databaseURL: "https://gps-traker-4de59-default-rtdb.firebaseio.com",
            projectId: "gps-traker-4de59",
            storageBucket: "gps-traker-4de59.appspot.com",
            messagingSenderId: "1022974399912",
            appId: "1:1022974399912:web:c37050b0029174b655b99d"
        };

    window.initialize = initialize;
    firebase.initializeApp(FirebaseConfig);

    var ref = firebase.database().ref();
        ref.on("value", function(snapshot) {
            var gps = snapshot.val();
            console.log(gps.LAT);
            console.log(gps.LNG);
            lat = gps.LAT;
            lng = gps.LNG;

            map.setCenter({lat:lat, lng:lng, alt:0});
            mark.setPosition({lat:lat, lng:lng, alt:0});

            lineCoords.push(new google.maps.LatLng(lat, lng));

            var lineCoordinatesPath = new google.maps.Polyline({
                path: lineCoords,
                geodesic: true,
                strokeColor: '#2E10FF'
            });

            lineCoordinatesPath.setMap(map);
        }, function (error) {
            console.log("Error: " + error.code);
        });
</script>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="photo">
                <h3>photo</h3>
            </div>
            <?php
            if(isset($使用者姓名)) {
                echo "<h2>" . $使用者姓名 . "</h2>";
                echo "<a href='m-information.php?search_keyword=$search_keyword' class='profile-button'>患者資料</a>";
            }
            ?>
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
            <div class="navbar">
                <div class="navi-thispage"><a href="m-current.php<?php echo isset($search_keyword) ? '?search_keyword=' . $search_keyword : ''; ?>">目前測量數據</a></div>
                <div class="navi"><a href="m-today.php<?php echo isset($search_keyword) ? '?search_keyword=' . $search_keyword : ''; ?>">當日平均數據</a></div>
                <div class="navi"><a href="m-history.php<?php echo isset($search_keyword) ? '?search_keyword=' . $search_keyword : ''; ?>">歷史數據</a></div>
            </div>

            <div class="data-grid">
                <div class="grid-up">
                    <h3>心率</h3>
                    <p><span id="heartRate"></span> bpm</p>
                </div>
                <div class="grid-up">
                    <h3>溫度</h3>
                    <p><span id="temp"></span> °C</p>
                </div>
                <div class="grid-down">
                    <h3>血氧</h3>
                    <p><span id="spo2"></span> % SpO₂</p>
                </div>
                <div class="grid-down">
                    <!-- <h3>GPS</h3> -->
                    <center><div id="map-canvas"></div></center>
                </div>
            </div>
        </div>
    </div>
</body>
</html>