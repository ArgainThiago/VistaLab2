<?php
include("../../Backend/Conexion.php");


if (isset($_GET['Cedula_D']) && is_numeric($_GET['Cedula_D'])) {
    $Cedula_D = (int) $_GET['Cedula_D'];
} else {
    die("Cédula del Doctor inválida.");
}

$Cedula_D = (int) $_GET['Cedula_D'];
$result = mysqli_query($conn, "SELECT * FROM doctor WHERE Cedula_D=$Cedula_D");
$Doctor = mysqli_fetch_assoc($result);

if (!$Doctor) {
    die("Doctor no encontrado.");
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $Nombre_D        = mysqli_real_escape_string($conn, $_POST['Nombre_D']);
    $His_med         = mysqli_real_escape_string($conn, $_POST['His_med']);
    $ID_Administrador= mysqli_real_escape_string($conn, $_POST['ID_Administrador']);
    $Tel             = mysqli_real_escape_string($conn, $_POST['Tel']);
    $Correo          = mysqli_real_escape_string($conn, $_POST['Correo']);
    $Contraseña_D    = mysqli_real_escape_string($conn, $_POST['Contraseña_D']);
    $Usuario_D       = mysqli_real_escape_string($conn, $_POST['Usuario_D']);

    $sql = "UPDATE doctor SET 
                Nombre_D='$Nombre_D', 
                His_med='$His_med', 
                ID_Administrador='$ID_Administrador',
                Tel='$Tel', 
                Correo='$Correo', 
                Contraseña_D='$Contraseña_D', 
                Usuario_D='$Usuario_D'
            WHERE Cedula_D=$Cedula_D";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Doctor actualizado correctamente');window.location.href='../PaginaDeMedicos.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Doctor</title>
  <link rel="stylesheet" href="../estiloL.css">
  <link rel="stylesheet" href="../Estilo.css">
</head>
<body>

<div class="cuadrado">
  <div class="titulo">
    <h1>Editar Doctor</h1>
  </div>
  <div class="info-paciente">
    <form method="POST" action="">
        Nombre: <input type="text" name="Nombre_D" value="<?php echo htmlspecialchars($Doctor['Nombre_D']); ?>" required><br>
        Historial Médico: <input type="text" name="His_med" value="<?php echo htmlspecialchars($Doctor['His_med']); ?>" required><br>
        ID del Administrador: <input type="number" name="ID_Administrador" value="<?php echo $Doctor['ID_Administrador']; ?>" required><br>
        Tel: <input type="text" name="Tel" value="<?php echo htmlspecialchars($Doctor['Tel']); ?>" required><br>
        Correo: <input type="email" name="Correo" value="<?php echo htmlspecialchars($Doctor['Correo']); ?>" required><br>
        Contraseña: <input type="text" name="Contraseña_D" value="<?php echo htmlspecialchars($Doctor['Contraseña_D']); ?>" required><br>
        Usuario: <input type="text" name="Usuario_D" value="<?php echo htmlspecialchars($Doctor['Usuario_D']); ?>" required><br><br>

        <button type="submit">Actualizar</button>
        <button type="button" onclick="location.href='../PaginaDeMedicos.php'">Volver</button>
    </form>
  </div>
</div>

</body>
</html>
