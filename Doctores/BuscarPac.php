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
        ORDER BY c.Fecha_Consulta ASC, c.Horario ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cedula_doctor);
$stmt->execute();
$consultas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SaludLab-Citas</title>
<link rel="stylesheet" href="Estilomedico.css">
</head>
<body>
<button class="Robot"></button>

<div class="superior">
    <div class="group">
  <svg viewBox="0 0 24 24" aria-hidden="true" class="search-icon">
    <g>
      <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
    </g>
  </svg>

  <input id="query" class="input" type="search" placeholder="Buscar pacientes..." name="searchbar"/>
  <button onclick="location.href='../Administradores/Doctor/Agregar.php'" class="Agregar">Agregar</button>
</div>


    <p class="Texto">SaludLab - <?php echo htmlspecialchars($nombre_doctor); ?></p>
    <img src="../Imagenes/logohospital.png" alt="logo" class="logo">
</div>

<h1 class="Cita">Pacientes</h1>

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
    <button class="Reprogramar" onclick="location.href='reprogramar.php?id=<?php echo $cita['Numero']; ?>'">Reprogramar</button>
</th>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay citas registradas.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

</body>
</html>
