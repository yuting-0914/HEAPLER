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
const app = firebase.initializeApp(FirebaseConfig);

var firebaseRefHeartRate = firebase.database().ref().child('heart rate');
var firebaseRefSpo2 = firebase.database().ref().child('spo2');
var firebaseRefTemp = firebase.database().ref().child('temp');
var firebaseRefCon = firebase.database().ref().child('condition');

function updateElementValue(elementId, value) {
    var element = document.getElementById(elementId);
    if (element) {
        element.innerText = value;
    } else {
        console.error("Element with ID " + elementId + " not found.");
    }
}
firebaseRefHeartRate.on("value", function(snapshot) {
    var heartRate = snapshot.val();
    updateElementValue("heartRate", heartRate);
    if (heartRate < 60 || heartRate > 120) {
        updateElementColor("heartRate", "red");
    } else {
        updateElementColor("heartRate", "black");
    }
});

firebaseRefSpo2.on("value", function(snapshot) {
    var spo2 = snapshot.val();
    updateElementValue("spo2", spo2);
    if (spo2 < 95) {
        updateElementColor("spo2", "red");
    } else {
        updateElementColor("spo2", "black");
    }
});

firebaseRefTemp.on("value", function(snapshot) {
    var temp = snapshot.val();
    updateElementValue("temp", temp);
    if (temp < 35.0 || temp > 37.5) {
        updateElementColor("temp", "red");
    } else {
        updateElementColor("temp", "black");
    }
});


firebaseRefCon.on("value", function(snapshot) {
    var condition = snapshot.val();
    updateElementValue("condition", condition);
    updateStatusElement(condition);
});

function updateElementColor(elementId, color) {
    var element = document.getElementById(elementId);
    if (element) {
        element.style.color = color;
    } else {
        console.error("Element with ID " + elementId + " not found.");
    }
}

function updateStatusElement(condition) {
    var statusElement = document.getElementById("status");
    if (statusElement) {
        if (condition === "狀態良好") {
            statusElement.innerHTML = '<div class="status-box good">狀態良好</div>';
        } else if (condition === "狀態正常") {
            statusElement.innerHTML = '<div class="status-box normal">狀態正常</div>';
        } else if (condition === "請留意您的身體狀況") {
            statusElement.innerHTML = '<div class="status-box warning"></div>';
        }
    } else {
        console.error("Status element not found.");
    }
}