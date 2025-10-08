<?php
session_start();
include '../Base de datos/Conexion.php';

$medico = $_GET['medico'] ?? null;
$fecha = $_GET['fecha'] ?? null;

if (!$medico || !$fecha) die("Faltan datos.");

$stmt = $conn->prepare("SELECT ID_Consulta, Horario 
                        FROM consulta 
                        WHERE Cedula_D = ? AND Fecha_Consulta = ? AND Estado = 'Disponible'
                        ORDER BY Horario ASC");
$stmt->bind_param("is", $medico, $fecha);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Seleccionar Hora</title>
<link rel="stylesheet" href="../Administradores/estiloL.css">
<link rel="stylesheet" href="../Administradores/Estilo.css">
</head>
<body>

<div class="cuadrado">
  <div class="titulo"><h1>Seleccione un horario</h1></div>
  <form action="guardar_cita.php" method="POST">
    <input type="hidden" name="medico" value="<?= $medico ?>">
    <input type="hidden" name="fecha" value="<?= $fecha ?>">

    <?php
    if ($res->num_rows === 0) {
        echo "<p>No hay horarios disponibles para esta fecha.</p>";
    } else {
        while ($r = $res->fetch_assoc()) {
            echo "<button type='submit' name='consulta' value='{$r['ID_Consulta']}'>{$r['Horario']}</button><br>";
        }
    }
    ?>
  </form>
</div>

</body>
</html>
