<?php 
include("../Conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){


$Correo= mysqli_real_escape_string($conn, $_POST['Correo']);
$Tel= mysqli_real_escape_string($conn, $_POST['Tel']);
$Contraseña_P=mysqli_real_escape_string($conn, $_POST['Contraseña_P']);
$Cedula_P=mysqli_real_escape_string($conn, $_POST['Cedula_P']);
$Fecha_Nac=mysqli_real_escape_string($conn, $_POST['Fecha_Nac']);
$His_med=mysqli_real_escape_string($conn, $_POST['His_med']);
$Sexo=mysqli_real_escape_string($conn, $_POST['Sexo']);
$Nombre_P=mysqli_real_escape_string($conn, $_POST['Nombre_P']);
$Contraseña_P=mysqli_real_escape_string($conn, $_POST['Contraseña_P']);
$Usuario_P=mysqli_real_escape_string($conn, $_POST['Usuario_P']);
if (!empty($Correo)&& !empty($Tel)&& !empty($Contraseña_P)&& !empty($Nombre_P)&& !empty($Cedula_P)&& !empty($Fecha_Nac)&& !empty($Sexo)&& !empty($His_med)&& !empty($Contraseña_P)&& !empty($Usuario_P)){
    $sql = "INSERT INTO paciente (Correo, Tel, Contraseña_P, Nombre_P, Cedula_P, Fecha_Nac, Sexo, His_med, Contraseña_P, Usuario_P) VALUES ('$Correo', '$Tel', '$Contraseña_P', '$Nombre_P', '$Cedula_P', '$Fecha_Nac', '$Sexo', '$His_med', '$Contraseña_P', '$Usuario_P')";
    if(mysqli_query($conn, $sql)){
        echo "Paciente agregado correctamente.";
    }
    else{
        echo"Error: " . mysqli_error($conn);
    }                       }else{
        echo"Por favor completa todos los campos";
}

}


?>
<from method="POST" action="">
    Usuario del paciente: <input type="text" name="Usuario_P"><br>
    Contraseña del paciente: <input type="email" name="Contraseña_P"><br>
    Correo: <input type="email" name="Correo"><br>
    Tel: <input Type="number" name="Tel"><br>
    Contraseña: <input Type="text" name="Contraseña_P"><br>
    Cedula del paciente: <input Type="number" name="Cedula_P"><br>
    Historial medico: <input Type="text" name="His_med"><br>
  <label for="genero-masculino">Masculino:</label>
  <input type="radio" id="genero-masculino" name="genero" value="masculino">
  <label for="genero-femenino">Femenino:</label>
  <input type="radio" id="genero-femenino" name="genero" value="femenino">

    Nombre del paciente: <input Type="text" name="Nombre_P"><br>
    Fecha de nacimiento<input Type="date" name="Fecha_Nac"><br>

    <button type="submit">Guardar</button>

</from>