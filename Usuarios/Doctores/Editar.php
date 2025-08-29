<?php
include("../Conexion.php");

$Cedula_D = $_GET['Cedula_D'];
$result=mysqli_query($conn, "SELECT * FROM doctor WHERE Cedula_D=$Cedula_D");
$Administrador=mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $Nombre_D=mysqli_real_escape_string($conn, $_POST['Nombre_D']);
    $Correo=mysqli_real_escape_string($conn, $_POST['Correo']);
    $His_med=mysqli_real_escape_string($conn, $_POST['His_med']);
    $Tel=mysqli_real_escape_string($conn, $_POST['Tel']);
    $Contraseña_A=mysqli_real_escape_string($conn, $_POST['Contraseña_D']);
    $ID_Administrador=mysqli_real_escape_string($conn, $_POST['ID_Administrador']);
    

    $_sql="UPDATE doctor SET Nombre_D='$Nombre_D', His_med='$His_med', Tel='$tel', Correo='$Correo', Contraseña_D='$Contraseña_A', ID_Administrador=$ID_Administrador WHERW Cedula_D=$Cedula_D";
    if (mysqli_query($conn, $sql)){
        echo "Doctor actualizado correctamente. ";

    }else{
        echo"Error:" . mysqli_error($conn);
    }
}

?>
<from method="POST" action="">
    Nombre: <input type="text" name="Nombre" value="<?php echo $Administrador['Nombre_D']; ?>"><br>
    Historial Medico: <input type="text" name="Nombre" value="<?php echo $Administrador['His_med']; ?>"><br>
    ID del administrador: <input type="text" name="Nombre" value="<?php echo $Administrador['ID_Administrador']; ?>"><br>
    Tel: <input type="text" name="Nombre" value="<?php echo $Administrador['Tel']; ?>"><br>
    Correo: <input type="text" name="Correo" value="<?php echo $Administrador['Correo']; ?>"><br>
    Contraseña: <input type="text" name="Contraseña_A" value="<?php echo $Administrador['Contraseña_D']; ?>"><br>
    <button type="submit">Actualizar</button>
    <a href="listar.php">Volver</a>
</from>