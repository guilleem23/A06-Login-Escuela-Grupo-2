<?php

$servername = "localhost:3306";
$dbusername = "root";
$dbpassword = "";
$dbname = ""; 

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $dbusername, $dbpassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die('Error de conexión a la base de datos.');
}

?>