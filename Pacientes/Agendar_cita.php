<?php
session_start();
include '../Base de datos/Conexion.php'; 

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente') {
    header("Location: ../login.html");
    exit();
}

$usuario_sesion = $_SESSION['usuario'];

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

$fechaSeleccionada = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
$hoy = date('Y-m-d');

if ($fechaSeleccionada < $hoy) {
    echo "<script>alert('No se puede seleccionar una fecha pasada.'); window.location.href='calendario.php';</script>";
    exit();
}


$especialidades = $conn->query("SELECT DISTINCT Nom_Especialidad FROM especialidad");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendar cita</title>
  <link rel="stylesheet" href="../estiloL.css">
  <link rel="stylesheet" href="Estilo.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="cuadrado">
  <div class="titulo">
    <h1>Agendar cita</h1>
  </div>
  <div class="info-paciente">
    <p>Paciente: <?php echo htmlspecialchars($nombre_paciente); ?></p>
    <p>Cédula: <?php echo htmlspecialchars($cedula_paciente); ?></p>
    <p>Fecha seleccionada: <?php echo htmlspecialchars($fechaSeleccionada); ?></p>

    <form method="post" action="guardar_cita.php">
        <input type="hidden" name="fecha" value="<?php echo $fechaSeleccionada; ?>">
        <input type="hidden" name="cedula_p" value="<?php echo $cedula_paciente; ?>">

        <p>
            <label for="especialidad">Especialidad:</label>
            <select name="nombre_especialidad" id="especialidad" required>
                <option value="">Seleccione la especialidad</option>
                <?php while($esp = $especialidades->fetch_assoc()): ?>
                    <option value="<?php echo $esp['Nom_Especialidad']; ?>"><?php echo $esp['Nom_Especialidad']; ?></option>
                <?php endwhile; ?>
            </select>
        </p>

        <p>
            <label for="medico">Médico:</label>
            <select name="cedula_d" id="medico" required>
                <option value="">Seleccione el médico</option>
            </select>
        </p>

        <p>
            <label for="horario">Horario:</label>
            <select name="hora" id="horario" required>
                <option value="">Seleccione el horario</option>
            </select>
        </p>

        <p>
            <input type="submit" value="Agendar" />
        </p>
    </form>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#especialidad').change(function() {
        var nombre_especialidad = $(this).val();
        if(nombre_especialidad) {
            $.ajax({
                type: 'POST',
                url: 'obtener_medicos.php',
                data: {nombre_especialidad: nombre_especialidad},
                success: function(html) {
                    $('#medico').html(html);
                    $('#horario').html('<option value="">Seleccione el horario</option>');
                }
            });
        } else {
            $('#medico').html('<option value="">Seleccione el médico</option>');
            $('#horario').html('<option value="">Seleccione el horario</option>');
        }
    });

    $('#medico').change(function() {
        var cedula_d = $(this).val();
        var fecha = $('input[name="fecha"]').val();
        if(cedula_d && fecha) {
            $.ajax({
                type: 'POST',
                url: 'obtener_horarios.php',
                data: {cedula_d: cedula_d, fecha: fecha},
                success: function(html) {
                    $('#horario').html(html);
                }
            });
        } else {
            $('#horario').html('<option value="">Seleccione el horario</option>');
        }
    });
});
</script>
</body>
</html>
