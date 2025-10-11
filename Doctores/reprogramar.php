<?php
session_start();
include("../Backend/Conexion.php");

if(!isset($_GET['id'])){
    die("No se especificó la cita.");
}

$id_consulta = (int)$_GET['id'];

$stmt = $conn->prepare("
    SELECT c.ID_Consulta, c.Fecha_Consulta, c.Horario, c.Cedula_D, p.Nombre_P 
    FROM consulta c
    LEFT JOIN paciente p ON c.Cedula_P = p.Cedula_P
    WHERE c.ID_Consulta=?
");
$stmt->bind_param("i", $id_consulta);
$stmt->execute();
$cita = $stmt->get_result()->fetch_assoc();

if(!$cita){
    die("Cita no encontrada.");
}

$cedula_doctor = $cita['Cedula_D'];
$nombre_paciente = $cita['Nombre_P'];
$fecha_actual = $cita['Fecha_Consulta'];
$hora_actual = $cita['Horario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reprogramar Cita</title>
<link rel="stylesheet" href="Reprogramar.css">
</head>
<body>

<div class="cuadrado">
    <h2 class="titulo">Reprogramar cita de <?php echo htmlspecialchars($nombre_paciente); ?></h2>

    <form action="ActualizaCita.php" method="POST">
        <input type="hidden" name="id_consulta" value="<?php echo $id_consulta; ?>">

        <div class="info-paciente">
            <label>Fecha:</label>
            <input type="date" name="fecha" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $fecha_actual; ?>" required>
        </div>

        <div class="info-paciente">
            <label>Horario:</label>
            <select name="hora" required>
                <?php
                $horarios = ["08:00:00","09:00:00","10:00:00","11:00:00","15:00:00","16:00:00","17:00:00"];

                $stmt2 = $conn->prepare("
                    SELECT Horario 
                    FROM consulta 
                    WHERE Cedula_D=? 
                    AND Fecha_Consulta=? 
                    AND Estado='Ocupado' 
                    AND ID_Consulta<>?
                ");
                $stmt2->bind_param("isi", $cedula_doctor, $fecha_actual, $id_consulta);
                $stmt2->execute();
                $res = $stmt2->get_result();
                $ocupados = [];
                while($row = $res->fetch_assoc()){
                    $ocupados[] = $row['Horario'];
                }

                foreach($horarios as $h){
                    if(!in_array($h, $ocupados)){
                        $selected = ($h == $hora_actual) ? "selected" : "";
                        echo "<option value='$h' $selected>$h</option>";
                    }
                }

                $stmt2->close();
                ?>
            </select>
        </div>

        <button type="submit">Reprogramar</button>
        <button type="button" onclick="window.history.back();" class="Atras">Atrás</button>
    </form>
</div>

</body>
</html>
