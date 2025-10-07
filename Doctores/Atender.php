<?php
session_start();
include '../Base de datos/Conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'medico') {
    header("Location: ../login.html");
    exit();
}

// Obtener ID de la cita
if (!isset($_GET['id'])) {
    die("ID de cita no proporcionado.");
}
$id_cita = (int)$_GET['id'];

// Obtener información de la cita y del paciente
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

// Procesar formulario de atención médica
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diagnostico = mysqli_real_escape_string($conn, $_POST['diagnostico']);
    $tratamiento = mysqli_real_escape_string($conn, $_POST['tratamiento']);
    $indicaciones = mysqli_real_escape_string($conn, $_POST['indicaciones']);

    // Formatear la nueva entrada como bloque separado
    $entrada = "-------------------------\n";
    $entrada .= "fecha de consulta: {$paciente['Fecha_Consulta']}\n";
    $entrada .= "Diagnostico: {$diagnostico}\n";
    $entrada .= "Tratamiento: {$tratamiento}\n";
    $entrada .= "Indicaciones: {$indicaciones}\n";

    $nuevo_historial = $paciente['His_med'] . "\n" . $entrada;

    // Actualizar historial
    $stmt = $conn->prepare("UPDATE paciente SET His_med = ? WHERE Cedula_P = ?");
    $stmt->bind_param("ss", $nuevo_historial, $paciente['Cedula_P']);

    if ($stmt->execute()) {
        $stmt->close();

        // Eliminar la cita
        $stmt_del = $conn->prepare("DELETE FROM consulta WHERE ID_Consulta = ?");
        $stmt_del->bind_param("i", $id_cita);
        if ($stmt_del->execute()) {
            $stmt_del->close();
            echo "<script>alert('Historial actualizado y cita eliminada correctamente.'); window.location.href='Pag_Medico.php';</script>";
            exit();
        } else {
            die("Error al eliminar la cita.");
        }
    } else {
        die("Error al actualizar el historial.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atender Paciente</title>
  <link rel="stylesheet" href="../Administradores/estiloL.css">
  <link rel="stylesheet" href="../Administradores/Estilo.css">
  <style>
    .historial-bloque {
        background-color: #f0f0f0;
        border-left: 4px solid #3498db;
        padding: 10px;
        margin-bottom: 10px;
        white-space: pre-wrap; /* Para respetar saltos de línea */
        font-family: monospace;
        color: black;
    }
    textarea {
        width: 100%;
        resize: vertical;
    }
    input[readonly] {
        background-color: #eaeaea;
    }
  </style>
</head>
<body>

<div class="cuadrado">
  <div class="titulo">
    <h1>Atender Paciente</h1>
  </div>
  <div class="info-paciente">
    <form method="POST" action="">
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

        Diagnóstico:<br>
        <textarea name="diagnostico" rows="3" required></textarea><br>
        Tratamiento:<br>
        <textarea name="tratamiento" rows="3" required></textarea><br>
        Indicaciones:<br>
        <textarea name="indicaciones" rows="3" required></textarea><br><br>

        <button type="submit">Guardar Atención</button>
        <button type="button" onclick="window.history.back();">Volver</button>
    </form>
  </div>
</div>

</body>
</html>
