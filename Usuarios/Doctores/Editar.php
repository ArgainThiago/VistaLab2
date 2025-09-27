<?php
include("../Conexion.php");

if (!isset($_GET['Cedula_D']) || !is_numeric($_GET['Cedula_D'])) {
    die("Cédula del doctor inválida.");
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
    $Contraseña_A    = mysqli_real_escape_string($conn, $_POST['Contraseña_A']);
    $Usuario_D       = mysqli_real_escape_string($conn, $_POST['Usuario_D']);

    $sql = "UPDATE doctor SET 
                Nombre_D='$Nombre_D', 
                His_med='$His_med', 
                ID_Administrador='$ID_Administrador',
                Tel='$Tel', 
                Correo='$Correo', 
                Contraseña_D='$Contraseña_A', 
                Usuario_D='$Usuario_D'
            WHERE Cedula_D=$Cedula_D";

    if (mysqli_query($conn, $sql)) {
        echo "Doctor actualizado correctamente.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST" action="">
    Nombre: <input type="text" name="Nombre_D" value="<?php echo htmlspecialchars($Doctor['Nombre_D']); ?>" required><br>
    Historial Médico: <input type="text" name="His_med" value="<?php echo htmlspecialchars($Doctor['His_med']); ?>" required><br>
    ID del administrador: <input type="number" name="ID_Administrador" value="<?php echo $Doctor['ID_Administrador']; ?>" required><br>
    Tel: <input type="text" name="Tel" value="<?php echo htmlspecialchars($Doctor['Tel']); ?>" required><br>
    Correo: <input type="email" name="Correo" value="<?php echo htmlspecialchars($Doctor['Correo']); ?>" required><br>
    Contraseña: <input type="text" name="Contraseña_A" value="<?php echo htmlspecialchars($Doctor['Contraseña_D']); ?>" required><br>
    Usuario: <input type="text" name="Usuario_D" value="<?php echo htmlspecialchars($Doctor['Usuario_D']); ?>" required><br>
    <button type="submit">Actualizar</button>
    <a href="listar.php">Volver</a>
</form>
