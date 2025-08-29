<?php 
include("../Conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

$Correo= mysqli_real_escape_string($conn, $_POST['Correo']);
$Tel= mysqli_real_escape_string($conn, $_POST['Tel']);
$Contraseña_A=mysqli_real_escape_string($conn, $_POST['Contraseña_A']);
if (!empty($Correo)&& !empty($Tel)&& !empty($Contraseña_A)){
    $sql = "INSERT INTO administrador (Correo, Tel, Contraseña_A) VALUES ('$Correo', '$Tel', '$Contraseña_A')";
    if(mysqli_query($conn, $sql)){
        echo "Administrador agregado correctamente.";
    }
    else{
        echo"Error: " . mysqli_error($conn);
    }                       }else{
        echo"Por favor completa todos los campos";
}

}


?>
<from method="POST" action="">
    Correo: <input type="email" name="Correo"><br>
    Tel: <input Type="number" name="Tel"><br>
    Contraseña: <input Type="text" name="Contraseña_A"><br>
    <button type="submit">Guardar</button>

</from>