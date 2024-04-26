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
    

    // 健保卡號初始化
    $card = '';

    if(isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) {
        $search_keyword = $_GET['search_keyword'];

        $sql="SELECT 使用者姓名 FROM 使用者 WHERE 健保卡號 = '$search_keyword' OR 病歷號='$search_keyword'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $使用者姓名 = $row['使用者姓名'];
            $card = $row['card'];
            $病歷號 = $row['病歷號'];
        }
    }

    if(isset($_SESSION['card'])) {
        $card = $_SESSION['card'];

        $sql="SELECT 使用者姓名 FROM 使用者 WHERE 健保卡號 = '$card'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $使用者姓名 = $row['使用者姓名'];
        }
    }
    else {
        echo "請先登入！";
        exit;
    }   
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALPER</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-database-compat.js"></script>
    <script type="module" src="test.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCaDAfZPctTUNxJx6mxCVbTdXd38exVRYk&callback=initialize" async defer></script>
</head>


<body>
    <div class="container">
        <div class="sidebar">
            <?php
                if(isset($使用者姓名)) {
                    echo "<h2>" . $使用者姓名 . "</h2>";
                    echo "<a href='information.php?card=$card' class='profile-button'>個人資料</a>";
                }
            ?>

            <div class="photo">
                <h3>photo</h3>
            </div>
            

            <div class="status-container">
                <div id="suggestion"></div>
                <div id="status"></div>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <div class="navbar">
                <div class="navi-thispage"><a href="current.php">目前測量數據</a></div>
                <div class="navi"><a href="today.php">當日平均數據</a></div>
                <div class="navi"><a href="history.php">歷史數據</a></div>
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

        var firebaseRefCon = firebase.database().ref().child('condition'); 

        firebaseRefCon.on("value", function(snapshot) {
            var condition = snapshot.val();
            var statusElement = document.getElementById("status");
            var healthStatus = getHealthStatus(condition);
            statusElement.innerHTML = '<div class="status-box ' + healthStatus.class + '">' + healthStatus.text + '</div>';

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var suggestion = this.responseText;
                    if (suggestion.trim() !== "") {
                        // 衛教建議存在時才顯示溫馨提醒
                        document.getElementById("suggestion").innerHTML = '<div class="reminder">溫馨提醒</div>' + suggestion;
                    } else {
                        // 衛教建議不存在時，清空建議內容
                        document.getElementById("suggestion").innerHTML = "";
                    }
                }
            };
            xhttp.open("GET", "get_advice.php?status=" + encodeURIComponent(healthStatus.text), true);
            xhttp.send();
        });
    </script>
</body>
</html>
