<?php
session_start();
include '../Base de datos/Conexion.php';
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente') {
    header("Location: ../login.html");
    exit();
}
$usuario_sesion = $_SESSION['usuario'];
$stmt = $conn->prepare("SELECT Cedula_P, Nombre_P, Sexo, Fecha_Nac, His_med FROM paciente WHERE Usuario_P = ?");
$stmt->bind_param("s", $usuario_sesion);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    die("Paciente no encontrado.");
}
$paciente = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial Médico</title>
  <link rel="stylesheet" href="../estiloL.css">
  <link rel="stylesheet" href="Estilo.css">
  <style>
    .historial-bloque { background-color:#f0f0f0; border-left:4px solid #3498db; padding:10px; margin-bottom:10px; white-space:pre-wrap; font-family:monospace; color:black; }
    input[readonly]{ background-color:#eaeaea; border:none; padding:8px; width:100%; border-radius:4px; margin-bottom:8px; }
  </style>
</head>
<body>
<div class="cuadrado">
  <div class="titulo">
    <h1>Historial Médico</h1>
  </div>
  <div class="info-paciente">
    Nombre: <input type="text" value="<?php echo htmlspecialchars($paciente['Nombre_P']); ?>" readonly><br>
    Cédula: <input type="text" value="<?php echo htmlspecialchars($paciente['Cedula_P']); ?>" readonly><br>
    Sexo: <input type="text" value="<?php echo htmlspecialchars($paciente['Sexo']); ?>" readonly><br>
    Fecha de Nacimiento: <input type="text" value="<?php echo htmlspecialchars($paciente['Fecha_Nac']); ?>" readonly><br><br>
    Historial Médico:<br>
    <?php
    $hist = $paciente['His_med'] ?? '';
    $historiales = array_filter(array_map('trim', explode("-------------------------", $hist)));
    foreach ($historiales as $bloque) {
        echo '<div class="historial-bloque">' . htmlspecialchars($bloque) . '</div>';
    }
    ?>
    <br>
    <p>
      <button type="button" class="Volver2" onclick="window.history.back();">Volver</button>
    </p>
  </div>
</div>
</body>
</html>
