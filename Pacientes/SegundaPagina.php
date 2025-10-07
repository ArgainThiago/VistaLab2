<?php
session_start();
include '../Base de datos/Conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente') {
    header("Location: ../login.html");
    exit();
}

$usuario_sesion = $_SESSION['usuario'];


$stmt = $conn->prepare("SELECT Nombre_P, Cedula_P FROM paciente WHERE Usuario_P=?");
$stmt->bind_param("s", $usuario_sesion);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $nombre_paciente = $row['Nombre_P'];
    $cedula_paciente = $row['Cedula_P'];
} else {
    die("Error: no se encontró el paciente.");
}
$stmt->close();

$hoy = date('Y-m-d');


$sql = "SELECT 
            c.ID_Consulta AS Numero,
            c.Fecha_Consulta AS Fecha,
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
            c.Fecha_Consulta DESC";

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

    <button class="hamburger" onclick="toggleMenu()">☰</button>
    <nav id="menu" class="menu">
        <ul>
            <li><a href="../inicio.html">Inicio</a></li>
        </ul>
    </nav>

    <div class="superior">
        <button onclick="location.href='Agenda.html'" class="mi-boton">Agregar Cita</button>
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
                        <th>Especialidad</th>
                        <th>Médico</th>
                        <th>Acción / Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($consultas->num_rows > 0): ?>
                        <?php while ($cita = $consultas->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cita['Fecha']); ?></td>
                                <td><?php echo htmlspecialchars($cita['Especialidad']); ?></td>
                                <td><?php echo htmlspecialchars($cita['Medico']); ?></td>
                                <td>
                                    <?php if ($cita['Estado'] === 'Cancelado' || $cita['Fecha'] < $hoy): ?>
                                        <?php echo ($cita['Estado'] === 'Cancelado') ? 'Cancelado' : 'La fecha ya pasó'; ?>
                                    <?php else: ?>
                                        <form method="get" action="Eliminar.php" style="display:inline;">
                                            <input type="hidden" name="ID_Consulta" value="<?php echo $cita['Numero']; ?>">
                                            <input type="submit" value="Cancelar" class="NoConcurrio" onclick="return confirm('¿Seguro que deseas cancelar esta cita? Esta acción no se puede deshacer.');">
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No tienes citas agendadas.</td>
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
    </script>
</body>
</html>
