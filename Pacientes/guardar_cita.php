<?php
session_start();
include '../Base de datos/Conexion.php';

if(!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente'){
    header("Location: ../login.html");
    exit();
}

if(!isset($_SESSION['cedula_d'], $_SESSION['nombre_especialidad'])){
    echo "<script>alert('No se seleccionó médico o especialidad'); window.location.href='Agendar_cita.php';</script>";
    exit();
}

if(!isset($_POST['fecha'], $_POST['hora'])){
    echo "<script>alert('No se seleccionó fecha u horario'); window.history.back();</script>";
    exit();
}

$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$cedula_d = $_SESSION['cedula_d'];
$especialidad = $_SESSION['nombre_especialidad'];

$usuario_sesion = $_SESSION['usuario'];
$stmt = $conn->prepare("SELECT Cedula_P FROM paciente WHERE Usuario_P=?");
$stmt->bind_param("s", $usuario_sesion);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows !== 1){
    echo "<script>alert('Paciente no encontrado'); window.location.href='../login.html';</script>";
    exit();
}

$cedula_p = $result->fetch_assoc()['Cedula_P'];
$stmt->close();

// Buscar ID de la especialidad
$stmt2 = $conn->prepare("SELECT ID_Especialidad FROM especialidad WHERE Nom_Especialidad=? LIMIT 1");
$stmt2->bind_param("s", $especialidad);
$stmt2->execute();
$result2 = $stmt2->get_result();

if($result2->num_rows !== 1){
    echo "<script>alert('Especialidad no encontrada'); window.location.href='Agendar_cita.php';</script>";
    exit();
}

$id_especialidad = $result2->fetch_assoc()['ID_Especialidad'];
$stmt2->close();

// Insertar la cita en la tabla consulta
$stmt3 = $conn->prepare("INSERT INTO consulta (Cedula_D, ID_Especialidad, Fecha_Consulta, Horario, Cedula_P, Estado) VALUES (?, ?, ?, ?, ?, 'Ocupado')");
$stmt3->bind_param("iisss", $cedula_d, $id_especialidad, $fecha, $hora, $cedula_p);

if($stmt3->execute()){
    echo "<script>alert('Cita agendada correctamente'); window.location.href='SegundaPagina.php';</script>";
} else {
    echo "<script>alert('Error al agendar cita'); window.history.back();</script>";
}

$stmt3->close();
$conn->close();
?>
