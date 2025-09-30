<?php
session_start();
include '../Base de datos/Conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'medico') {
    header("Location: ../login.html");
    exit();
}

$usuario_sesion = $_SESSION['usuario'];

$stmt = $conn->prepare("SELECT Cedula_D, Nombre_D FROM doctor WHERE Usuario_D=?");
$stmt->bind_param("s", $usuario_sesion);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $cedula_doctor = $row['Cedula_D'];
    $nombre_doctor = $row['Nombre_D'];
} else {
    die("Error: médico no encontrado.");
}

$stmt->close();

$hoy = date('Y-m-d');
$manana = date('Y-m-d', strtotime('+1 day'));


$sql = "SELECT 
            c.ID_Consulta AS Numero,
            c.Fecha_Consulta AS Fecha,
            e.Nom_Especialidad AS Especialidad,
            p.Nombre_P AS Paciente,
            c.Estado
        FROM consulta c
        INNER JOIN especialidad e ON c.ID_Especialidad = e.ID_Especialidad
        LEFT JOIN paciente p ON c.Cedula_P = p.Cedula_P
        WHERE c.Cedula_D = ? AND c.Fecha_Consulta BETWEEN ? AND ? AND c.Estado='Ocupado'
        ORDER BY c.Fecha_Consulta ASC, c.Horario ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $cedula_doctor, $hoy, $manana);
$stmt->execute();
$consultas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SaludLab-Citas</title>
<link rel="stylesheet" href="SegundaPagina.css">
</head>
<body>
<button class="Robot"></button>

<div class="superior">
    <button onclick="location.href='BuscarPac.html'" class="pac">Pacientes</button>
    <button onclick="location.href='Agenda.html'" class="Boton">Agenda</button> 
    <p class="Texto">SaludLab - <?php echo htmlspecialchars($nombre_doctor); ?></p>
    <img src="../Imagenes/logohospital.png" alt="logo" class="logo">
</div>

<h1 class="Cita">Citas Hoy y Mañana</h1>

<div class="tablas">
    <div class="estilos">
        <table>
            <tr>
                <th class="lateral">Tipo</th>
                <th>Detalle de la cita</th>
                <th class="asistencia">Acciones</th>
            </tr>
            <?php if ($consultas->num_rows > 0): ?>
                <?php while ($cita = $consultas->fetch_assoc()): ?>
                    <tr>
                        <th class="lateral"><?php echo htmlspecialchars($cita['Especialidad']); ?></th>
                        <th>
                            Fecha: <?php echo htmlspecialchars($cita['Fecha']); ?> 
                            Paciente: <?php echo htmlspecialchars($cita['Paciente']); ?>
                        </th>
                        <th class="asistencia">
                            <button class="NoConcurrio">No Concurrió</button>
                            <button class="Reprogramar">Reprogramar</button>
                        </th>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay citas pendientes para hoy o mañana.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

</body>
</html>
