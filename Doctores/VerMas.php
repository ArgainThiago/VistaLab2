<?php
session_start();
include '../Base de datos/Conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'medico') {
    header("Location: ../login.html");
    exit();
}


if (!isset($_GET['id'])) {
    die("ID de cita no proporcionado.");
}
$id_cita = (int)$_GET['id'];


$stmt = $conn->prepare("
    SELECT p.Nombre_P, p.Cedula_P, p.Sexo, p.Fecha_Nac, p.His_med, c.Fecha_Consulta
    FROM consulta c
    INNER JOIN paciente p ON c.Cedula_P = p.Cedula_P
    WHERE c.ID_Consulta = ?
");
$stmt->bind_param("i", $id_cita);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Cita no encontrada o paciente no existe.");
}

$paciente = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Paciente</title>
  <link rel="stylesheet" href="../Administradores/estiloL.css">
  <link rel="stylesheet" href="../Administradores/Estilo.css">
  <style>
    .historial-bloque {
        background-color: #f0f0f0;
        border-left: 4px solid #3498db;
        padding: 10px;
        margin-bottom: 10px;
        white-space: pre-wrap; 
        font-family: monospace;
        color: black;
    }
    input[readonly] {
        background-color: #eaeaea;
    }
  </style>
</head>
<body>

<div class="cuadrado">
  <div class="titulo">
    <h1>Datos del Paciente</h1>
  </div>
  <div class="info-paciente">
        Nombre: <input type="text" value="<?php echo htmlspecialchars($paciente['Nombre_P']); ?>" readonly><br>
        Cédula: <input type="text" value="<?php echo htmlspecialchars($paciente['Cedula_P']); ?>" readonly><br>
        Sexo: <input type="text" value="<?php echo htmlspecialchars($paciente['Sexo']); ?>" readonly><br>
        Fecha de Nacimiento: <input type="text" value="<?php echo htmlspecialchars($paciente['Fecha_Nac']); ?>" readonly><br><br>

        Historial Médico:<br>
        <?php
        $historiales = explode("-------------------------", $paciente['His_med']);
        foreach ($historiales as $bloque) {
            if (trim($bloque) !== "") {
                echo '<div class="historial-bloque">' . htmlspecialchars(trim($bloque)) . '</div>';
            }
        }
        ?>
        <br>

        <button type="button" onclick="window.history.back();">Volver</button>
  </div>
</div>

</body>
</html>
