<?php
session_start();
include("../Backend/Conexion.php");

$dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

if(isset($_GET['fecha'])){
    $timestamp = strtotime($_GET['fecha']);
    $fecha_seleccionada = date('Y-m-d', $timestamp); 
} else {
    $timestamp = time();
    $fecha_seleccionada = date('Y-m-d', $timestamp);
}

$fecha_dia_semana = $dias[date('w', $timestamp)];
$fecha_dia_mes = date('d', $timestamp);
$fecha_mes = $meses[date('n', $timestamp) - 1];
$fecha_ano = date('Y', $timestamp);

$sql = "SELECT c.ID_Consulta AS Numero, c.Fecha_Consulta, p.Nombre_P, e.Nom_Especialidad
        FROM consulta c
        INNER JOIN paciente p ON c.Cedula_P = p.Cedula_P
        INNER JOIN especialidad e ON c.ID_Especialidad = e.ID_Especialidad
        WHERE c.Fecha_Consulta = ?
        ORDER BY c.Horario ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fecha_seleccionada);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendas</title>
    <link rel="stylesheet" href="Agendas.css">
</head>
<body>

<button class="hamburger" onclick="toggleMenu()">☰</button>

<nav id="menu" class="menu">
    <ul>
        <li><a href="../inicio.html">Cerrar Sesion</a></li>
    </ul>
</nav>

<div class="superior">
   <button class="anterior" onclick="location.href='Agenda.html'">Atras</button>
   <p class="Texto">SaludLab</p>
   <img src="../Imagenes/logohospital.png" alt="logo" class="logo">
</div>

<h1 class="Cita">Agendas</h1>

<div class="tablas">
 <div class="fech">
    <?php echo htmlspecialchars($fecha_dia_semana); ?> 
    <?php echo htmlspecialchars($fecha_dia_mes); ?> de
    <?php echo htmlspecialchars($fecha_mes); ?>
</div>

<div class="estilos">
    <table>
        <tr>
            <th class="lateral">Especialidad</th>
            <th>Detalle de la cita</th>
            <th>Acciones</th>
        </tr>
        <?php if($result->num_rows > 0): ?>
            <?php while($cita = $result->fetch_assoc()): ?>
                <tr>
                    <th class="lateral"><?php echo htmlspecialchars($cita['Nom_Especialidad']); ?></th>
                    <th>Fecha: <?php echo htmlspecialchars($cita['Fecha_Consulta']); ?> Paciente: <?php echo htmlspecialchars($cita['Nombre_P']); ?></th>
                    <th><button class="Atender" onclick="location.href='VerMas.php?id=<?php echo $cita['Numero']; ?>'">Ver Mas</button></th>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No hay citas para este día.</td>
            </tr>
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
