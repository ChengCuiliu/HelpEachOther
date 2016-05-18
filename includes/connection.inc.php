<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "help_each_other";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("SET NAMES utf8");

// 检测连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
