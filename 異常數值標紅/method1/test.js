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
var firebaseRefTemp = firebase.database().ref().child('temp');
var firebaseRefSpo2 = firebase.database().ref().child('spo2');
var firebaseRefCon = firebase.database().ref().child('condition');

firebaseRefHeartRate.on("value", function(snapshot) {
    var heartRate = snapshot.val();
    // document.getElementById("heartRate").innerText = heartRate;
    var heartRateElement = document.getElementById("heartRate");
    heartRateElement.innerText = heartRate;
    if (heartRate < 40 || heartRate > 120) {
        heartRateElement.style.color = "red";
    } else {
        heartRateElement.style.color = "black";
    }
});

firebaseRefTemp.on("value", function(snapshot) {
    var temp = snapshot.val();
    // document.getElementById("temp").innerText = temp;
    var tempElement = document.getElementById("temp");
    tempElement.innerText = temp;
    if (temp < 35.5 || temp > 37.5) {
        tempElement.style.color = "red";
    } else {
        tempElement.style.color = "black";
    }
});

firebaseRefSpo2.on("value", function(snapshot) {
    var spo2 = snapshot.val();
    // document.getElementById("spo2").innerText = spo2;
    var spo2Element = document.getElementById("spo2");
    spo2Element.innerText = spo2;
    if (spo2 < 95) {
        spo2Element.style.color = "red";
    } else {
        spo2Element.style.color = "black";
    }
});

firebaseRefCon.on("value", function(snapshot) {
    var condition = snapshot.val();
    document.getElementById("condition").innerText = condition;
});