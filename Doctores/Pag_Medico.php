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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['no_concurrio_id'])) {
    $id_consulta = (int)$_POST['no_concurrio_id'];


    $check = $conn->prepare("SELECT ID_Consulta FROM consulta WHERE ID_Consulta=? AND Cedula_D=? AND Fecha_Consulta=?");
    $check->bind_param("iis", $id_consulta, $cedula_doctor, $hoy);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows === 1) {
        $delete = $conn->prepare("DELETE FROM consulta WHERE ID_Consulta=?");
        $delete->bind_param("i", $id_consulta);
        $delete->execute();
        $delete->close();
        echo "<script>alert('La cita fue eliminada correctamente.');</script>";
    } else {
        echo "<script>alert('No se puede eliminar: solo se eliminan las citas de hoy.');</script>";
    }

    $check->close();
}

$sql = "SELECT 
            c.ID_Consulta AS Numero, 
            c.Fecha_Consulta AS Fecha, 
            e.Nom_Especialidad AS Especialidad, 
            p.Nombre_P AS Paciente, 
            c.Estado 
        FROM consulta c
        INNER JOIN especialidad e ON c.ID_Especialidad = e.ID_Especialidad
        LEFT JOIN paciente p ON c.Cedula_P = p.Cedula_P
        WHERE c.Cedula_D = ? 
          AND c.Fecha_Consulta BETWEEN ? AND ? 
          AND c.Estado = 'Ocupado'
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
    <title>SaludLab - Citas</title>
    <link rel="stylesheet" href="SegundaPagina.css">
</head>
<body>
<button class="hamburger" onclick="toggleMenu()">☰</button>

<nav id="menu" class="menu">
    <ul>
        <li><a href="../inicio.html">Inicio</a></li>
    </ul>
</nav>

<div class="superior">
    <button onclick="location.href='BuscarPac.php'" class="pac">Pacientes</button>
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
                            Fecha: <?php echo htmlspecialchars($cita['Fecha']); ?><br>
                            Paciente: <?php echo htmlspecialchars($cita['Paciente']); ?>
                        </th>
                        <th class="asistencia">
                         
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="no_concurrio_id" value="<?php echo $cita['Numero']; ?>">
                                <input type="submit" class="NoConcurrio" value="No Concurrió" onclick="return confirm('¿Eliminar esta cita?');">
                            </form>

                    
                            <form method="get" action="reprogramar.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $cita['Numero']; ?>">
                                <input type="submit" class="Reprogramar" value="Reprogramar">
                            </form>

                         
                            <form method="get" action="Atender.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $cita['Numero']; ?>">
                                <input type="submit" class="Atender" value="Atender">
                            </form>
                        </th>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">No hay citas pendientes para hoy o mañana.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<script>
function toggleMenu() {
    document.getElementById("menu").classList.toggle("show");
}
</script>
</body>
</html>
