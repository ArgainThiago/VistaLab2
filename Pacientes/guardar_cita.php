<?php
session_start();
include '../Base de datos/Conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente') {
    header("Location: ../login.html");
    exit();
}

if(isset($_POST['cedula_p'], $_POST['id_especialidad'], $_POST['cedula_d'], $_POST['fecha'], $_POST['hora'])){
    
    $cedula_p = $_POST['cedula_p'];
    $id_especialidad = $_POST['id_especialidad'];
    $cedula_d = $_POST['cedula_d'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    $stmt_check = $conn->prepare("SELECT * FROM consulta WHERE Cedula_D=? AND Fecha_Consulta=? AND Horario=? AND Estado='Ocupado'");
    $stmt_check->bind_param("iss", $cedula_d, $fecha, $hora);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if($result_check->num_rows > 0){
        echo "<script>alert('Ese horario ya está ocupado. Por favor seleccione otro.'); window.history.back();</script>";
        exit();
    }

    $stmt_check->close();

    $stmt_insert = $conn->prepare("INSERT INTO consulta (Cedula_D, ID_Especialidad, Fecha_Consulta, Horario, Cedula_P, Estado) VALUES (?, ?, ?, ?, ?, 'Ocupado')");
    $stmt_insert->bind_param("iisss", $cedula_d, $id_especialidad, $fecha, $hora, $cedula_p);

    if($stmt_insert->execute()){
     echo "<script>alert('Cita agendada con éxito'); window.location.href='http://localhost/VistaLab/Pacientes/SegundaPagina.php';</script>";

    } else {
        echo "<script>alert('Error al guardar la cita'); window.location.href='Agenda.php';</script>";
    }

    $stmt_insert->close();
} else {
    echo "<script>alert('Faltan datos para agendar la cita'); window.history.back();</script>";
}

$conn->close();
?>
