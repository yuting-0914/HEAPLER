<?php
// 資料庫連接
$mysqli = new mysqli("localhost", "root", "sinyu0306", "Healper");

// 檢查連接是否成功
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// 資料庫查詢
$sql = "SELECT CONCAT(DATE_FORMAT(量測時間, '%H'), ':', LPAD((MINUTE(量測時間) DIV 5) * 5, 2, '0')) AS minute_interval, AVG(體溫) AS avg_temperature, AVG(血氧) AS avg_blood_oxygen, AVG(心率) AS avg_heart_rate FROM 健康數據 GROUP BY minute_interval ORDER BY minute_interval ASC";
$result = $mysqli->query($sql);

$minute_averages = array();

// 將查詢結果放入關聯數組中
while ($row = $result->fetch_assoc()) {
    $minute_averages[] = $row;
}

// 關閉 MySQL 連接
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <title>HEALPER</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h2>Name</h2>
            <a href="" class="profile-button">患者病歷</a>
            <div class="photo">
                <h3>photo</h3>
            </div>
            <div class="medical-profile">
                <div class="medical-photo">
                    <h5>photo</h5>
                </div>
                <div class="medical-data">
                    <p>Name</p>
                    <p>ID:XXXXXXXXXX</p>
                    <a href="" class="medical-profile-button">個人主頁</a>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>HEALPER</h1>
            <div class="navbar">
                <div class="navi"><a href="m-current.html">目前測量數據</a></div>
                <div class="navi"><a href="m-today.php">當日平均數據</a></div>
                <div class="navi-thispage"><a href="m-history.php">歷史數據</a></div>
            </div>
            <div class="data-grid" id="average">
                <!-- 折線圖放置處 -->
                <div class="grid-up" id="heart-rate-chart">
                    <canvas id="heartRateChart" width="400" height="300"></canvas>
                </div>
                <div class="grid-up" id="temperature-chart">
                    <canvas id="temperatureChart" width="400" height="300"></canvas>
                </div>
                <div class="grid-up" id="blood-oxygen-chart">
                    <canvas id="bloodOxygenChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        var historyData = <?php echo json_encode($minute_averages); ?>;

        // 從歷史數據中提取時間戳和平均值
        var minute_interval = historyData.map(entry => entry['minute_interval']);
        var temperatureData = historyData.map(entry => entry['avg_temperature']);
        var heartRateData = historyData.map(entry => entry['avg_heart_rate']);
        var bloodOxygenData = historyData.map(entry => entry['avg_blood_oxygen']);

        // 做心率圖表
        var heartRateCtx = document.getElementById('heartRateChart').getContext('2d');
        var heartRateChart = new Chart(heartRateCtx, {
            type: 'line',
            data: {
                labels: minute_interval,
                datasets: [{
                    label: '心率',
                    data: heartRateData,
                    borderColor: 'black',
                    borderWidth: 1,
                    fill: false,
                    pointRadius: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            unit: 'minute', // 設置時間單位
                            displayFormats: {
                                minute: 'H:mm'
                            }
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + 'bpm';
                            return label;
                        }
                    }
                },
            }
        });

        // 做體溫圖表
        var temperatureCtx = document.getElementById('temperatureChart').getContext('2d');
        var temperatureChart = new Chart(temperatureCtx, {
            type: 'line',
            data: {
                labels: minute_interval,
                datasets: [{
                    label: '體溫',
                    data: temperatureData,
                    borderColor: 'black',
                    borderWidth: 1,
                    fill: false,
                    pointRadius: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            unit: 'minute', // 設置時間單位
                            displayFormats:{
                                minute: 'H:mm'
                            }
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0
                        }
                    }],
                    
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return value + '°C'; // 添加單位
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + '°C';
                            return label;
                        }
                    }
                },

            }
        });

        // 做血氧圖表
        var bloodOxygenCtx = document.getElementById('bloodOxygenChart').getContext('2d');
        var bloodOxygenChart = new Chart(bloodOxygenCtx, {
            type: 'line',
            data: {
                labels: minute_interval,
                datasets: [{
                    label: '血氧',
                    data: bloodOxygenData,
                    borderColor: 'black',
                    borderWidth: 1,
                    fill: false,
                    pointRadius: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            unit: 'minute', // 設置時間單位
                            displayFormats: {
                                minute: 'H:mm'
                            }
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + '%';
                            return label;
                        }
                    }
                },
            }
        });
    </script>
</body>
</html>