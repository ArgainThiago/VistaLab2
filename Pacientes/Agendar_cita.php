<?php
session_start();
include '../Base de datos/Conexion.php'; 

//Verificarsi hay paciente logueado
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente') {
    header("Location: ../login.html");
    exit();
}

//Obtenemos el usuario de la sesion
$usuario_sesion = $_SESSION['usuario'];

// Consultamo el nombre y la cédula del paciente en la base de datos
$stmt = $conn->prepare("SELECT Nombre_P, Cedula_P FROM paciente WHERE Usuario_P=?");
$stmt->bind_param("s", $usuario_sesion);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $nombre_paciente = $row['Nombre_P'];
    $cedula_paciente = $row['Cedula_P'];
} else {
    $nombre_paciente = "Paciente";
    $cedula_paciente = "N/A";
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendar cita</title>
  <link rel="stylesheet" href="../estiloL.css">
  <link rel="stylesheet" href="Estilo.css">
</head>
<body>
<div class="cuadrado">
  <div class="titulo">
    <h1>Agendar cita</h1>
  </div>
  <div class="info-paciente">
    <p>Paciente: <?php echo htmlspecialchars($nombre_paciente); ?></p>
    <p>Cédula: <?php echo htmlspecialchars($cedula_paciente); ?></p>
  </div>


  <div class="info">
    <form method="get" action="#">
  
  <p>
    <label for="faviteOnlyor">Especialidad:</label>
    <select name="favoriteOnly" id="favoriteOnly">
      <option>Cardiólogo</option>
      <option>Neurocirujano</option>
      <option>Medicina general</option>
      <option>Cirujano</option>
      <option>Pediatra</option>
    </select>
  </p>
  <p>
    <label for="faviteOnlyor">Medico:</label>
    <select name="favoriteOnly" id="favoriteOnly">
      <option>Cardiólogo</option>
      <option>Neurocirujano</option>
      <option>Medicina general</option>
      <option>Cirujano</option>
      <option>Pediatra</option>
    </select>
  </p>
   <p>
    <label for="faviteOnlyor">Hora:</label>
    <select name="favoriteOnly" id="favoriteOnly">
      <option>Mañana</option>
      <option>Tarde</option>
    </select>
  </p>
  <p>
    <input type="submit" value="Enviar" />
  </p>
</form>
  </div>
</div>


</body>
</html>
