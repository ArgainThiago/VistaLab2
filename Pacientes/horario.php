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

$stmt = $conn->prepare("SELECT Horario FROM consulta WHERE Cedula_D=? AND Fecha_Consulta=? AND Estado='Disponible' ORDER BY Horario ASC");
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
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    display: flex;
    justify-content: center;
    padding: 20px;
}
.cuadrado {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    width: 350px;
    text-align: center;
}
.cuadrado h1 {
    margin-bottom: 20px;
    color: #333;
}
button, select, input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}
button:hover, input[type="submit"]:hover {
    background: #007BFF;
    color: white;
    cursor: pointer;
}
a {
    text-decoration: none;
    color: #007BFF;
}
a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<div class="cuadrado">
    <h1>Seleccionar Horario</h1>
    <p>Fecha seleccionada: <?php echo htmlspecialchars($fecha); ?></p>

    <?php if(count($horarios) > 0): ?>
        <form method="post" action="guardar_cita.php">
            <input type="hidden" name="cedula_d" value="<?php echo $cedula_d; ?>">
            <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">

            <select name="hora" required>
                <option value="">Seleccione un horario</option>
                <?php foreach($horarios as $h): ?>
                    <option value="<?php echo htmlspecialchars($h); ?>"><?php echo htmlspecialchars($h); ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Agendar Cita">
        </form>
    <?php else: ?>
        <p>No hay horarios disponibles para esta fecha.</p>
        <a href="Agenda.php">Volver al calendario</a>
    <?php endif; ?>
</div>
</body>
</html>
