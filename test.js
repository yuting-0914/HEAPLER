// Import the functions you need from the SDKs you need
//import { initializeApp } from "https://www.gstatic.com/firebasejs/9.1.2/firebase-app.js";
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

firebaseRefHeartRate.on("value", function(snapshot) {
    var heartRate = snapshot.val();
    document.getElementById("heartRate").innerText = heartRate;
});

firebaseRefSpo2.on("value", function(snapshot) {
    var spo2 = snapshot.val();
    document.getElementById("spo2").innerText = spo2;
});

firebaseRefTemp.on("value", function(snapshot) {
    var temp = snapshot.val();
    document.getElementById("temp").innerText = temp;
});

firebaseRefCon.on("value", function(snapshot) {
    var condition = snapshot.val();
    document.getElementById("condition").innerText = condition;
});
// Listen for changes in condition node
firebaseRefCon.on("value", function(snapshot) {
    var condition = snapshot.val();
    var statusElement = document.getElementById("status");

    if (condition === "狀態正常") {
        statusElement.innerHTML = '<div class="status-box normal">狀態正常</div>';
    } else if (condition === "狀態良好") {
        statusElement.innerHTML = '<div class="status-box good">狀態良好</div>';
    } else if (condition === "請留意您的身體狀況") {
        statusElement.innerHTML = '<div class="status-box warning">請留意您的身體狀況</div>';
    }
});
