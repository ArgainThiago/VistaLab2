<?php
$host = 'localhost';
$db = 'prueba'; 
$user = 'root';
$pass = ''; 

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
