<?php
session_start();
include("../Usuarios/Conexion.php");

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


$sql = "SELECT c.ID_Consulta, c.Fecha_Consulta, p.Nombre_P, e.Nom_Especialidad
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
 <button onclick="location.href=''" class="Agregar">Agregar</button>
 
 <div class="superior">
   <div class="group">
      <svg viewBox="0 0 24 24" aria-hidden="true" class="search-icon">
        <g>
          <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
        </g>
      </svg>

      <input
        id="query"
        class="input"
        type="search"
        placeholder="Buscar citas..."
        name="searchbar"
      />
  </div>

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
                    <th><button class="Reprogramar">Reprogramar</button></th>
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

</body>
</html>
