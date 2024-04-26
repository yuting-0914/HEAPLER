// Import the functions you need from the SDKs you need
//import { initializeApp } from "https://www.gstatic.com/firebasejs/9.1.2/firebase-app.js";
//import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.8.1/firebase-app.js';
//import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/9.1.2/firebase-database.js";

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
//const app = firebase.initializeApp(FirebaseConfig);
firebase.initializeApp(FirebaseConfig);

var firebaseRefHeartRate = firebase.database().ref().child('heart rate');
var firebaseRefSpo2 = firebase.database().ref().child('spo2');
var firebaseRefTemp = firebase.database().ref().child('temp');
var firebaseRefCon = firebase.database().ref().child('condition');

function updateStatus(healthStatus, element) {
    var statusElement = document.getElementById("status");
    if (healthStatus.text.trim() !== "") {
        statusElement.innerHTML = '<div class="status-box ' + healthStatus.class + '">' + healthStatus.text + '</div>';
        if (healthStatus.class === "warning") {
            var statusForAdvice = encodeURIComponent(healthStatus.text);
            fetchAdvice(statusForAdvice);
        }
    } else {
        statusElement.innerHTML = '<div class="status-box normal"></div>'; // 空白表示正常
    }
    // 保留原始的顏色設置
    element.style.color = (healthStatus.class === "warning") ? "red" : "black";
}

var firebaseRefHeartRate = firebase.database().ref().child('heart rate');
firebaseRefHeartRate.on("value", function(snapshot) {
    var heartRate = snapshot.val();
    var heartRateElement = document.getElementById("heartRate");
    heartRateElement.innerText = heartRate;
    var healthStatus = getHealthStatusHeartRate(heartRate);
    updateStatus(healthStatus, heartRateElement);
});

var firebaseRefSpo2 = firebase.database().ref().child('spo2');
firebaseRefSpo2.on("value", function(snapshot) {
    var spo2 = snapshot.val();
    var spo2Element = document.getElementById("spo2");
    spo2Element.innerText = spo2;
    var healthStatus = getHealthStatusSpo2(spo2);
    updateStatus(healthStatus, spo2Element);
});

var firebaseRefTemp = firebase.database().ref().child('temp');
firebaseRefTemp.on("value", function(snapshot) {
    var temp = snapshot.val();
    var tempElement = document.getElementById("temp");
    tempElement.innerText = temp;
    var healthStatus = getHealthStatusTemp(temp);
    updateStatus(healthStatus, tempElement);
});

var firebaseRefCon = firebase.database().ref().child('condition');
firebaseRefCon.on("value", function(snapshot) {
    var condition = snapshot.val();
    var statusElement = document.getElementById("status");
    var healthStatus = getHealthStatus(condition);
    updateStatus(healthStatus, statusElement);
});

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
        return { text: "體溫高", class: "warning" };
    } else {
        return { text: "", class: "normal" }; // 空白表示正常
    }
}

function getHealthStatus(condition) {
    if (condition === "狀態良好") {
        return { text: "狀態良好", class: "good" };
    } else if (condition === "狀態正常") {
        return { text: " ", class: "normal" };
    } else if (condition === "請留意您的身體狀況") {
        return { text: " ", class: "warning" };
    }
} 

function fetchAdvice(status) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var suggestion = this.responseText;
            document.getElementById("suggestion").innerText = suggestion;
        }
    };
    xhttp.open("GET", "get_advice.php?status=" + status, true);
    xhttp.send();    
}

