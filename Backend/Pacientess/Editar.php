<?php
include("../Conexion.php");

if (isset($_GET['Cedula_P']) && is_numeric($_GET['Cedula_P'])) {
    $Cedula_P = (int) $_GET['Cedula_P'];
} else {
    die("Cédula del paciente inválida.");
}

$result = mysqli_query($conn, "SELECT * FROM paciente WHERE Cedula_P=$Cedula_P");
if (!$result || mysqli_num_rows($result) == 0) {
    die("Paciente no encontrado.");
}
$Paciente = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nombre_P     = isset($_POST['Nombre_P']) ? mysqli_real_escape_string($conn, $_POST['Nombre_P']) : '';
    $Fecha_Nac    = isset($_POST['Fecha_Nac']) ? mysqli_real_escape_string($conn, $_POST['Fecha_Nac']) : '';
    $Sexo         = isset($_POST['Sexo']) ? mysqli_real_escape_string($conn, $_POST['Sexo']) : '';
    $Correo       = isset($_POST['Correo']) ? mysqli_real_escape_string($conn, $_POST['Correo']) : '';
    $Tel          = isset($_POST['Tel']) ? mysqli_real_escape_string($conn, $_POST['Tel']) : '';
    $His_Med      = isset($_POST['His_Med']) ? mysqli_real_escape_string($conn, $_POST['His_Med']) : '';
    $Contraseña_P = isset($_POST['Contraseña_P']) ? mysqli_real_escape_string($conn, $_POST['Contraseña_P']) : '';
    $Usuario_P    = isset($_POST['Usuario_P']) ? mysqli_real_escape_string($conn, $_POST['Usuario_P']) : '';

    if (!empty($Nombre_P) && !empty($Fecha_Nac) && !empty($Sexo) &&
        !empty($Correo) && !empty($Tel) && !empty($His_Med) &&
        !empty($Contraseña_P) && !empty($Usuario_P)) {

        $sql = "UPDATE paciente SET 
                    Nombre_P='$Nombre_P',
                    Fecha_Nac='$Fecha_Nac',
                    Sexo='$Sexo',
                    Correo='$Correo',
                    Tel='$Tel',
                    His_Med='$His_Med',
                    Contraseña_P='$Contraseña_P',
                    Usuario_P='$Usuario_P'
                WHERE Cedula_P=$Cedula_P";

        if (mysqli_query($conn, $sql)) {
            echo "Paciente actualizado correctamente.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>

<form method="POST" action="">
    Nombre: <input type="text" name="Nombre_P" value="<?php echo isset($Paciente['Nombre_P']) ? htmlspecialchars($Paciente['Nombre_P']) : ''; ?>" required><br>
    Fecha de nacimiento: <input type="date" name="Fecha_Nac" value="<?php echo isset($Paciente['Fecha_Nac']) ? $Paciente['Fecha_Nac'] : ''; ?>" required><br>
    
    Sexo:
    <label for="genero-masculino">Masculino</label>
    <input type="radio" id="genero-masculino" name="Sexo" value="masculino" <?php if(isset($Paciente['Sexo']) && $Paciente['Sexo']=="masculino") echo "checked"; ?> required>
    <label for="genero-femenino">Femenino</label>
    <input type="radio" id="genero-femenino" name="Sexo" value="femenino" <?php if(isset($Paciente['Sexo']) && $Paciente['Sexo']=="femenino") echo "checked"; ?>><br>
    
    Correo: <input type="email" name="Correo" value="<?php echo isset($Paciente['Correo']) ? htmlspecialchars($Paciente['Correo']) : ''; ?>" required><br>
    Tel: <input type="text" name="Tel" value="<?php echo isset($Paciente['Tel']) ? htmlspecialchars($Paciente['Tel']) : ''; ?>" required><br>
    Historial médico: <input type="text" name="His_Med" value="<?php echo isset($Paciente['His_Med']) ? htmlspecialchars($Paciente['His_Med']) : ''; ?>" required><br>
    Contraseña: <input type="text" name="Contraseña_P" value="<?php echo isset($Paciente['Contraseña_P']) ? htmlspecialchars($Paciente['Contraseña_P']) : ''; ?>" required><br>
    Usuario: <input type="text" name="Usuario_P" value="<?php echo isset($Paciente['Usuario_P']) ? htmlspecialchars($Paciente['Usuario_P']) : ''; ?>" required><br>
    
    <button type="submit">Actualizar</button>
    <a href="listar.php">Volver</a>
</form>
