<?php
session_start();
include '../Base de datos/Conexion.php';

if(!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente'){
    header("Location: ../login.html");
    exit();
}

if(!isset($_SESSION['cedula_d']) || !isset($_POST['hora']) || !isset($_POST['fecha'])){
    echo "<script>alert('Datos insuficientes.'); window.location.href='Agendar_cita.php';</script>";
    exit();
}

$cedula_d = $_SESSION['cedula_d'];
$cedula_p = $_SESSION['cedula_p'] ?? null; // cédula del paciente guardada al iniciar sesión
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

// Validar que el horario siga disponible
$verificar = $conn->prepare("
    SELECT Estado 
    FROM consulta 
    WHERE Cedula_D=? AND Fecha_Consulta=? AND Horario=?");
$verificar->bind_param("iss", $cedula_d, $fecha, $hora);
$verificar->execute();
$result = $verificar->get_result();

if($result->num_rows === 0){
    echo "<script>alert('El horario no existe o ya fue tomado.'); window.location.href='Agenda.php';</script>";
    exit();
}

$row = $result->fetch_assoc();
if($row['Estado'] !== 'Disponible'){
    echo "<script>alert('El horario ya fue reservado por otro paciente.'); window.location.href='Agenda.php';</script>";
    exit();
}

// Actualizar la cita en la tabla "consulta"
$update = $conn->prepare("
    UPDATE consulta 
    SET Cedula_P=?, Estado='Ocupado'
    WHERE Cedula_D=? AND Fecha_Consulta=? AND Horario=?");
$update->bind_param("iiss", $cedula_p, $cedula_d, $fecha, $hora);

if($update->execute()){
    echo "<script>
        alert('Cita agendada correctamente para el $fecha a las $hora.');
        window.location.href='SegundaPagina.php';
    </script>";
} else {
    echo "<script>
        alert('Error al guardar la cita.');
        window.location.href='Agenda.php';
    </script>";
}

$verificar->close();
$update->close();
$conn->close();
?>
