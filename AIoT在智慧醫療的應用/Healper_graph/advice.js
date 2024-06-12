import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.8.1/firebase-app.js';
import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/9.1.2/firebase-database.js";

// Initialize Firebase for Sensor Data
const FirebaseConfig = {
    apiKey: "AIzaSyDAdJsgmpxoRN4aqg5vwEyliA6Zi5PBH3w",
    authDomain: "gps-traker-4de59.firebaseapp.com",
    databaseURL: "https://gps-traker-4de59-default-rtdb.firebaseio.com",
    projectId: "gps-traker-4de59",
    storageBucket: "gps-traker-4de59.appspot.com",
    messagingSenderId: "1022974399912",
    appId: "1:1022974399912:web:c37050b0029174b655b99d"
};
firebase.initializeApp(FirebaseConfig);

const firebaseRefHeartRate = firebase.database().ref().child('heart rate');
const firebaseRefSpo2 = firebase.database().ref().child('spo2');
const firebaseRefTemp = firebase.database().ref().child('temp');

// Firebase 數據監聽
firebaseRefHeartRate.on("value", function(snapshot) {
    var heartRate = snapshot.val();
    checkAndUpdateStatus({ type: "heartRate", value: heartRate });
});

firebaseRefSpo2.on("value", function(snapshot) {
    var spo2 = snapshot.val();
    checkAndUpdateStatus({ type: "spo2", value: spo2 });
});

firebaseRefTemp.on("value", function(snapshot) {
    var temp = snapshot.val();
    checkAndUpdateStatus({ type: "temp", value: temp });
});

// 檢查並更新狀態
function checkAndUpdateStatus(sensorData) {
    var { type, value } = sensorData;
    var healthStatus = "";

    switch (type) {
        case "heartRate":
            healthStatus = getHealthStatusHeartRate(value);
            break;
        case "spo2":
            healthStatus = getHealthStatusSpo2(value);
            break;
        case "temp":
            healthStatus = getHealthStatusTemp(value);
            break;
        default:
            break;
    }

    updateStatus(healthStatus);
    // 如果需要，獲取衛教建議
    if (healthStatus.class === "warning" || healthStatus.class === "danger") {
        fetchAdvice(healthStatus.text);
    }
}

// 更新狀態
function updateStatus(healthStatus) {
    var statusElement = document.getElementById("healthStatus");
    if (!statusElement) return; // 檢查元素是否存在

    statusElement.innerHTML = '<div class="status-box-health ' + healthStatus.class + '">' + healthStatus.text + '</div>';

    var adviceElement = document.getElementById("advice");
    if (!adviceElement) return; // 檢查元素是否存在

    if (healthStatus.class === "warning" || healthStatus.class === "danger") {
        fetchAdvice(healthStatus.text);
    } else {
        adviceElement.innerText = ""; // 清空建議
    }
}

// 狀態基於心率
function getHealthStatusHeartRate(heartRate) {
    if (heartRate < 60) {
        return { text: "心率低", class: "warning" };
    } else if (heartRate > 120) {
        return { text: "心率高", class: "warning" };
    } else {
        return { text: "", class: "normal" }; // 空白表示正常
    }
}

// 狀態基於血氧
function getHealthStatusSpo2(spo2) {
    if (spo2 < 95) {
        return { text: "血氧低", class: "warning" };
    } else {
        return { text: "", class: "normal" }; // 空白表示正常
    }
}

// 狀態基於體溫
function getHealthStatusTemp(temp) {
    if (temp < 35.0) {
        return { text: "體溫低", class: "warning" };
    } else if (temp > 37.5) {
        return { text: "體溫高", class: "danger" };
    } else {
        return { text: "", class: "normal" }; // 空白表示正常
    }
}

// 從 PHP 獲取建議
function fetchAdvice(status) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var suggestion = this.responseText;
            var suggestionElement = document.getElementById("suggestion");
            if (suggestionElement) suggestionElement.innerText = suggestion;
        }
    };
    xhttp.open("GET", "get_advice.php?status=" + status, true);
    xhttp.send();
}


