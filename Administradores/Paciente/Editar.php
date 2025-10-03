<?php
include("../../Usuarios/Conexion.php");


if (!isset($_GET['Cedula_P']) || !is_numeric($_GET['Cedula_P'])) {
    echo "Cédula del paciente inválida.";
    exit;
}
$Cedula_P = (int) $_GET['Cedula_P'];


$stmt = $conn->prepare("SELECT * FROM paciente WHERE Cedula_P=?");
if (!$stmt) {
    echo "Error en la preparación: " . $conn->error;
    exit;
}
$stmt->bind_param("i", $Cedula_P);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Paciente no encontrado.";
    exit;
}
$Paciente = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Nombre_P     = trim($_POST['Nombre_P'] ?? '');
    $Fecha_Nac    = $_POST['Fecha_Nac'] ?? '';
    $Sexo         = $_POST['Sexo'] ?? '';
    $Correo       = $_POST['Correo'] ?? '';
    $Tel          = $_POST['Tel'] ?? '';
    $His_Med      = $_POST['His_med'] ?? '';
    $Contraseña_P = $_POST['Contraseña_P'] ?? '';
    $Usuario_P    = $_POST['Usuario_P'] ?? '';

    if ($Nombre_P && $Fecha_Nac && $Sexo && $Correo && $Tel && $His_Med && $Contraseña_P && $Usuario_P) {
        $sql = "UPDATE paciente 
                SET Nombre_P=?, Fecha_Nac=?, Sexo=?, Correo=?, Tel=?, His_med=?, Contraseña_P=?, Usuario_P=? 
                WHERE Cedula_P=?";
        $update = $conn->prepare($sql);

        if (!$update) {
            echo "Error al preparar la actualización: " . $conn->error;
        } else {
            $update->bind_param(
                "ssssssssi",
                $Nombre_P,
                $Fecha_Nac,
                $Sexo,
                $Correo,
                $Tel,
                $His_Med,
                $Contraseña_P,
                $Usuario_P,
                $Cedula_P
            );

            if ($update->execute()) {
                echo "<script>
                        alert('Paciente actualizado correctamente');
                        window.location.href='../PaginaDePacientes.php';
                      </script>";
                exit;
            } else {
                echo "Error al ejecutar la actualización: " . $update->error;
            }
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Paciente</title>
  <link rel="stylesheet" href="../estiloL.css">
  <link rel="stylesheet" href="../Estilo.css">
</head>
<body>
<div class="cuadrado">
  <div class="titulo">
    <h1>Editar Paciente</h1>
  </div>
  <div class="info-paciente">
    <form method="POST" action="">
        Nombre: 
        <input type="text" name="Nombre_P" value="<?php echo htmlspecialchars($Paciente['Nombre_P']); ?>" required><br>

        Fecha de nacimiento: 
        <input type="date" name="Fecha_Nac" value="<?php echo $Paciente['Fecha_Nac']; ?>" required><br>
        
        Sexo:
        <label>
            <input type="radio" name="Sexo" value="Masculino" <?php if($Paciente['Sexo']=="Masculino") echo "checked"; ?>>Masculino
        </label>
        <label>
            <input type="radio" name="Sexo" value="Femenino" <?php if($Paciente['Sexo']=="Femenino") echo "checked"; ?>>Femenino
        </label><br>
        
        Correo: 
        <input type="email" name="Correo" value="<?php echo htmlspecialchars($Paciente['Correo']); ?>" required><br>

        Tel: 
        <input type="text" name="Tel" value="<?php echo htmlspecialchars($Paciente['Tel']); ?>" required><br>
        
        Historial médico:<br>
        <textarea name="His_med" rows="5" required><?php echo htmlspecialchars($Paciente['His_med']); ?></textarea><br>
        
        Contraseña: 
        <input type="text" name="Contraseña_P" value="<?php echo htmlspecialchars($Paciente['Contraseña_P']); ?>" required><br>

        Usuario: 
        <input type="text" name="Usuario_P" value="<?php echo htmlspecialchars($Paciente['Usuario_P']); ?>" required><br>
        
        <button type="submit">Actualizar</button>
        <button type="button" onclick="location.href='../PaginaDePacientes.php'">Volver</button>
    </form>
  </div>
</div>
</body>
</html>
