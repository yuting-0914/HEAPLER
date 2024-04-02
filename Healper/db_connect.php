<?php
    header("Content-Type:text/html; charset=UTF-8");

    $servername = "localhost";
    $username = "root";
    $password = "sinyu0306S";
    $database = "Healper";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("連線失敗: " . $conn->connect_error);
    }

    $conn->close();
?>