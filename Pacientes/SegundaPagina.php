<?php
session_start();
include '../Base de datos/Conexion.php';
date_default_timezone_set('America/Montevideo');

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente') {
    header("Location: ../login.html");
    exit();
}

$usuario_sesion = $_SESSION['usuario'];
$stmt = $conn->prepare("SELECT Nombre_P, Cedula_P FROM paciente WHERE Usuario_P = ?");
$stmt->bind_param("s", $usuario_sesion);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $nombre_paciente = $row['Nombre_P'];
    $cedula_paciente = $row['Cedula_P'];
    $_SESSION['cedula_p'] = $cedula_paciente;
} else {
    die("Error: no se encontró el paciente.");
}
$stmt->close();

$hoy = date('Y-m-d');

$sql = "
SELECT 
    c.ID_Consulta AS Numero,
    c.Fecha_Consulta AS Fecha,
    c.Horario,
    c.Estado,
    e.Nom_Especialidad AS Especialidad,
    d.Nombre_D AS Medico
FROM consulta c
INNER JOIN especialidad e ON c.ID_Especialidad = e.ID_Especialidad
INNER JOIN doctor d ON c.Cedula_D = d.Cedula_D
WHERE c.Cedula_P = ?
ORDER BY 
    CASE 
        WHEN c.Estado NOT IN ('Cancelado') AND c.Fecha_Consulta >= ? THEN 0 
        ELSE 1 
    END,
    c.Fecha_Consulta DESC, c.Horario DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $cedula_paciente, $hoy);
$stmt->execute();
$consultas = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SaludLab - Citas</title>
    <link rel="stylesheet" href="../SegundaPagina.css">
</head>
<body>
<button onclick="location.href='chatbot.php'" class="Robot"></button>
<button class="hamburger" onclick="toggleMenu()">☰</button>
<nav id="menu" class="menu">
    <ul>
        <li><a href="../inicio.html">Cerrar Sesión</a></li>
    </ul>
</nav>

<div class="superior">
    <button onclick="location.href='Agendar_cita.php'" class="mi-boton">Agregar Cita</button>
    <button onclick="location.href='Ficha_med.php'" class="mi-boton2">Ficha médica</button>
    <p class="Texto">SaludLab</p>
    <img src="../Imagenes/logohospital.png" alt="logo" class="logo">
</div>

<h1 class="Cita">Mis Citas</h1>

<div class="tablas">
    <div class="estilos">
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th class="fecha">Fecha</th>
                    <th>Hora</th>
                    <th>Especialidad</th>
                    <th>Médico</th>
                    <th>Acción / Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($consultas->num_rows > 0): ?>
                    <?php while ($cita = $consultas->fetch_assoc()): ?>
                        <?php
                        $fecha_cita = $cita['Fecha'];
                        $hora_cita = $cita['Horario'];
                        $estado = $cita['Estado'];
                        $fecha_hora_str = $fecha_cita . ' ' . $hora_cita;
                        $fecha_hora_cita = DateTime::createFromFormat('Y-m-d H:i:s', $fecha_hora_str, new DateTimeZone('America/Montevideo'));
                        if ($fecha_hora_cita === false) {
                            $fecha_hora_cita = DateTime::createFromFormat('Y-m-d H:i', $fecha_hora_str, new DateTimeZone('America/Montevideo'));
                        }
                        $ahora = new DateTime('now', new DateTimeZone('America/Montevideo'));
                        $ya_paso = ($fecha_hora_cita <= $ahora);
                        $segundos_faltan = $fecha_hora_cita->getTimestamp() - $ahora->getTimestamp();
                        ?>
                        <tr<?php if($ya_paso) echo ' style="opacity:0.7;"'; ?>>
                            <td><?php echo htmlspecialchars($fecha_cita); ?></td>
                            <td><?php echo htmlspecialchars($hora_cita); ?></td>
                            <td><?php echo htmlspecialchars($cita['Especialidad']); ?></td>
                            <td><?php echo htmlspecialchars($cita['Medico']); ?></td>
                            <td>
                                <?php if ($estado === 'Cancelado'): ?>
                                    Cancelado
                                <?php elseif ($ya_paso): ?>
                                    La fecha ya pasó
                                <?php else: ?>
                                    <?php if ($segundos_faltan < 3600): ?>
                                        No se puede cancelar con menos de 1 hora de anticipación
                                    <?php else: ?>
                                        <form method="post" action="Eliminar.php" style="display:inline;" onsubmit="return confirmarCancel(event, '<?php echo $fecha_cita; ?>', '<?php echo $hora_cita; ?>')">
                                            <input type="hidden" name="ID_Consulta" value="<?php echo $cita['Numero']; ?>">
                                            <input type="submit" value="Cancelar" class="NoConcurrio">
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No tienes citas agendadas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleMenu() {
    document.getElementById("menu").classList.toggle("show");
}
function confirmarCancel(e, fecha, hora) {
    var fechaCita = new Date(fecha + 'T' + hora);
    var ahora = new Date();
    var diffMs = fechaCita - ahora;
    if (diffMs < 0) {
        alert('La cita ya pasó.');
        return false;
    }
    if (diffMs < 3600 * 1000) {
        alert('No puedes cancelar la cita con menos de una hora de anticipación.');
        return false;
    }
    return confirm('¿Seguro que deseas cancelar esta cita?');
}
</script>
</body>
</html>
