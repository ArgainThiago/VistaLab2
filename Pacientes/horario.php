<?php
session_start();
include '../Base de datos/Conexion.php';

if(!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente'){
    header("Location: ../login.html");
    exit();
}

if(!isset($_SESSION['cedula_d'])){
    echo "<script>alert('No se seleccionó ningún médico'); window.location.href='Agendar_cita.php';</script>";
    exit();
}

if(!isset($_GET['fecha'])){
    echo "<script>alert('No se seleccionó ninguna fecha'); window.location.href='Agenda.php';</script>";
    exit();
}

$cedula_d = $_SESSION['cedula_d'];
$fecha = $_GET['fecha'];


$stmt = $conn->prepare("
    SELECT Horario 
    FROM consulta 
    WHERE Cedula_D=? 
    AND Fecha_Consulta=? 
    AND Estado='Disponible' 
    ORDER BY Horario ASC
");
$stmt->bind_param("is", $cedula_d, $fecha);
$stmt->execute();
$res = $stmt->get_result();

$horarios = [];
while($row = $res->fetch_assoc()){
    $horarios[] = $row['Horario'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seleccionar Horario</title>
<link rel="stylesheet" href="../estiloL.css">
<link rel="stylesheet" href="Estilo.css">
</head>
<body>
<div class="cuadrado">
  <div class="titulo">
    <h1>Seleccionar horario</h1>
  </div>

  <div class="info-paciente">
    <p>Fecha seleccionada: <strong><?php echo htmlspecialchars($fecha); ?></strong></p>

    <?php if(count($horarios) > 0): ?>
        <form method="post" action="guardar_cita.php">
            <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>">

            <p>
                <label for="hora">Horario:</label>
                <select name="hora" id="hora" required>
                    <option value="">Seleccione un horario</option>
                    <?php foreach($horarios as $h): ?>
                        <option value="<?php echo htmlspecialchars($h); ?>">
                            <?php echo htmlspecialchars($h); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <input class="Siguiente" type="submit" value="Agendar Cita">
                <button type="button" onclick="location.href='Agenda.php'" class="Volver">Volver</button>
            </p>
        </form>
    <?php else: ?>
        <p>No hay horarios disponibles para esta fecha.</p>
        <button onclick="location.href='Agenda.php'" class="Volver">Volver</button>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
