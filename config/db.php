<?php
session_start();

$host = "localhost";
$dbname = "shop";
$user = "root";
$pass = "";

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>