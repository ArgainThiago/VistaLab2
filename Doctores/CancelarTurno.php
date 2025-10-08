<?php
session_start();
include '../Base de datos/Conexion.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "UPDATE consulta SET Estado='Cancelado' WHERE ID_Consulta=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: GestionHorarios.php");
exit();
