<?php
     header("Content-Type:text/html; charset=UTF-8");
     $serverName="localhost";
     $connectionInfo=array(
        "Database"=>"Healper",
        "UID"=>"root",
        "PWD"=>"sinyu0306S",
        "CharacterSet" => "UTF-8",
        "TrustServerCertificate" => "yes");
     $conn=sqlsrv_connect($serverName,$connectionInfo);
         if($conn){
             echo "Success!!!<br />";
         }else{
             echo "Error!!!<br />";
             die(print_r(sqlsrv_errors(),true));
         }            
?>