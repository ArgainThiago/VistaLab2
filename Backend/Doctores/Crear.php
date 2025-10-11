<?php 
include("../Conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

$Cedula_D= mysqli_real_escape_string($conn, $_POST['Cedula_D']);
$Nombre_D=mysqli_real_escape_string($conn, $_POST['Nombre_D']);
$Correo=mysqli_real_escape_string($conn, $_POST['Correo']);
$His_med=mysqli_real_escape_string($conn, $_POST['His_med']);
$Tel= mysqli_real_escape_string($conn, $_POST['Tel']);
$Contraseña_D=mysqli_real_escape_string($conn, $_POST['Contraseña_D']);
$Usuario_D=mysqli_real_escape_string($conn, $_POST['Usuario_D']);
$ID_Administrador=mysqli_real_escape_string($conn, $_POST['ID_Administrador']);
if (!empty($Correo)&& !empty($Tel)&& !empty($Contraseña_D)&& !empty($Cedula_D)&& !empty($Nombre_D)&& !empty($His_med)&& !empty($ID_Administrador)&& !empty($Usuario_D)){
    $sql = "INSERT INTO doctor (Cedula_D,Nombre_D,Correo,His_med,tel,Contraseña_D,ID_Administrador, Usuario_D) VALUES ('$Cedula_D', '$Nombre_D', '$Correo','$His_med','$Tel','$Contraseña_D','$ID_Administrador','$Usuario_D')";
    if(mysqli_query($conn, $sql)){
        echo "Doctor agregado correctamente.";
    }
    else{
        echo"Error: " . mysqli_error($conn);
    }                       }else{
        echo"Por favor completa todos los campos";
}

}


?>
<form method="POST" action="">
    Nombre: <input Type="text" name="Nombre_D"><br>
    Cedula: <input Type="text" name="Cedula_D"><br> 
    Usuario: <input Type="text" name="Usuario_D"><br> 
    Contraseña: <input Type="text" name="Contraseña_D"><br>
    Correo: <input type="email" name="Correo"><br>
    Tel: <input Type="number" name="Tel"><br>
    Historial médico: <input Type="text" name="His_med"><br>
    ID del administrador: <input Type="text" name="ID_Administrador"><br>
    <button type="submit">Guardar</button>
    <a href="listar.php">Volver</a>

</form>