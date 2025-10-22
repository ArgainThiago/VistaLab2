<?php
session_start();
include '../Base de datos/Conexion.php';
date_default_timezone_set('America/Montevideo');

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente') {
    header("Location: ../login.html");
    exit();
}

if (!isset($_POST['ID_Consulta']) || !is_numeric($_POST['ID_Consulta'])) {
    echo "<script>alert('ID de consulta inválido.'); window.location.href='SegundaPagina.php';</script>";
    exit();
}

$id_consulta = (int)$_POST['ID_Consulta'];
$usuario = $_SESSION['usuario'];

$stmt = $conn->prepare("SELECT Cedula_P, Fecha_Consulta, Horario, Estado FROM consulta WHERE ID_Consulta = ?");
$stmt->bind_param("i", $id_consulta);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows !== 1) {
    echo "<script>alert('Cita no encontrada.'); window.location.href='SegundaPagina.php';</script>";
    exit();
}
$cita = $res->fetch_assoc();
$stmt->close();

if ($cita['Estado'] === 'Cancelado') {
    echo "<script>alert('La cita ya está cancelada.'); window.location.href='SegundaPagina.php';</script>";
    exit();
}

$stmt = $conn->prepare("SELECT Usuario_P, Cedula_P FROM paciente WHERE Cedula_P = ?");
$stmt->bind_param("i", $cita['Cedula_P']);
$stmt->execute();
$res2 = $stmt->get_result();
if ($res2->num_rows !== 1) {
    echo "<script>alert('Paciente no encontrado.'); window.location.href='SegundaPagina.php';</script>";
    exit();
}
$pac = $res2->fetch_assoc();
$stmt->close();

if ($pac['Usuario_P'] !== $usuario) {
    echo "<script>alert('No tienes permiso para cancelar esta cita.'); window.location.href='SegundaPagina.php';</script>";
    exit();
}

$fecha_hora_str = $cita['Fecha_Consulta'] . ' ' . $cita['Horario'];
$dt_cita = DateTime::createFromFormat('Y-m-d H:i:s', $fecha_hora_str, new DateTimeZone('America/Montevideo'));
if ($dt_cita === false) {
    $dt_cita = DateTime::createFromFormat('Y-m-d H:i', $fecha_hora_str, new DateTimeZone('America/Montevideo'));
}
$ahora = new DateTime('now', new DateTimeZone('America/Montevideo'));
$segundos = $dt_cita->getTimestamp() - $ahora->getTimestamp();

if ($segundos < 3600) {
    echo "<script>alert('No puedes cancelar la cita con menos de una hora de anticipación.'); window.location.href='SegundaPagina.php';</script>";
    exit();
}

$upd = $conn->prepare("UPDATE consulta SET Estado='Disponible', Cedula_P = NULL WHERE ID_Consulta = ?");
$upd->bind_param("i", $id_consulta);
if ($upd->execute()) {
    echo "<script>alert('Cita cancelada con éxito.'); window.location.href='SegundaPagina.php';</script>";
} else {
    echo "<script>alert('Error al cancelar la cita.'); window.location.href='SegundaPagina.php';</script>";
}
$upd->close();
$conn->close();
