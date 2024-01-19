<?php

$login = "admin";
$pass = "admin";

function GetConn(){
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = '164339_strona';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
    
?>