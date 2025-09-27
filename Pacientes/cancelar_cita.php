<?php
session_start();
include '../Base de datos/Conexion.php';


if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente') {
    header("Location: ../login.html");
    exit();
}

if(isset($_POST['id_consulta'])) {
    $id_consulta = $_POST['id_consulta'];

    $stmt = $conn->prepare("UPDATE consulta SET Estado='Disponible' WHERE ID_Consulta=?");
    $stmt->bind_param("i", $id_consulta);

    if($stmt->execute()) {
        echo "<script>alert('Cita cancelada con éxito'); window.location.href='SegundaPagina.php';</script>";
    } else {
        echo "<script>alert('Error al cancelar la cita'); window.location.href='SegundaPagina.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No se recibió la cita a cancelar'); window.location.href='SegundaPagina.php';</script>";
}

$conn->close();
?>
