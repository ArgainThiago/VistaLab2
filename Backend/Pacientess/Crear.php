<?php 
include("../Conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Correo       = mysqli_real_escape_string($conn, $_POST['Correo']);
    $Tel          = mysqli_real_escape_string($conn, $_POST['Tel']);
    $Contraseña_P = mysqli_real_escape_string($conn, $_POST['Contraseña_P']);
    $Cedula_P     = mysqli_real_escape_string($conn, $_POST['Cedula_P']);
    $Fecha_Nac    = mysqli_real_escape_string($conn, $_POST['Fecha_Nac']);
    $His_med      = mysqli_real_escape_string($conn, $_POST['His_med']);
    $Sexo         = mysqli_real_escape_string($conn, $_POST['Sexo']);
    $Nombre_P     = mysqli_real_escape_string($conn, $_POST['Nombre_P']);
    $Usuario_P    = mysqli_real_escape_string($conn, $_POST['Usuario_P']);

    if (!empty($Correo) && !empty($Tel) && !empty($Contraseña_P) && 
        !empty($Nombre_P) && !empty($Cedula_P) && !empty($Fecha_Nac) && 
        !empty($Sexo) && !empty($His_med) && !empty($Usuario_P)) {
        
        $sql = "INSERT INTO paciente 
                (Correo, Tel, Contraseña_P, Nombre_P, Cedula_P, Fecha_Nac, Sexo, His_med, Usuario_P) 
                VALUES 
                ('$Correo', '$Tel', '$Contraseña_P', '$Nombre_P', '$Cedula_P', '$Fecha_Nac', '$Sexo', '$His_med', '$Usuario_P')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Paciente agregado correctamente.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>

<form method="POST" action="">
    Usuario del paciente: <input type="text" name="Usuario_P" required><br>
    Contraseña del paciente: <input type="password" name="Contraseña_P" required><br>
    Correo: <input type="email" name="Correo" required><br>
    Tel: <input type="number" name="Tel" required><br>
    Cédula del paciente: <input type="number" name="Cedula_P" required><br>
    Historial médico: <input type="text" name="His_med" required><br>

    Sexo: 
    <label for="genero-masculino">Masculino</label>
    <input type="radio" id="genero-masculino" name="Sexo" value="masculino" required>
    <label for="genero-femenino">Femenino</label>
    <input type="radio" id="genero-femenino" name="Sexo" value="femenino"><br>

    Nombre del paciente: <input type="text" name="Nombre_P" required><br>
    Fecha de nacimiento: <input type="date" name="Fecha_Nac" required><br>

    <button type="submit">Guardar</button>
</form>
