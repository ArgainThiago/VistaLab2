<?php
$host="localhost";
$user="root";
$pass="";
$db="basededatos3";

$conn= mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Error en la conexión" . mysqli_connect_error());

}
?>