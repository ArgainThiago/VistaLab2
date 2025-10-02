<?php  
include("../../Usuarios/Conexion.php");

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
            echo "<script>alert('Paciente agregado correctamente');window.location.href='../PaginaDePacientes.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
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
  <title>Agregar Paciente</title>
  <link rel="stylesheet" href="../estiloL.css">
  <link rel="stylesheet" href="../Estilo.css">
</head>
<body>

<div class="cuadrado">
  <div class="titulo">
    <h1>Agregar Paciente</h1>
  </div>
  <div class="info-paciente">
    <form method="POST" action="">
        Usuario: <input type="text" name="Usuario_P" required><br>
        Contraseña: <input type="password" name="Contraseña_P" required><br>
        Correo: <input type="email" name="Correo" required><br>
        Tel: <input type="number" name="Tel" required><br>
        Cédula: <input type="number" name="Cedula_P" required><br>
        Historial médico: <input type="text" name="His_med" required><br>

        Sexo: 
        <label><input type="radio" name="Sexo" value="Masculino" required> Masculino</label>
        <label><input type="radio" name="Sexo" value="Femenino"> Femenino</label><br>

        Nombre: <input type="text" name="Nombre_P" required><br>
        Fecha de nacimiento: <input type="date" name="Fecha_Nac" required><br><br>

        <button type="submit">Guardar</button>
        <button type="button" onclick="location.href='../PaginaDePacientes.php'">Volver</button>
    </form>
  </div>
</div>

</body>
</html>
