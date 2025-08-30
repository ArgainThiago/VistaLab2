<?php
include("../Conexion.php");

$ID_Administrador = $_GET['ID_Administrador'];
$result=mysqli_query($conn, "SELECT * FROM administrador WHERE ID_Administrador=$ID_Administrador");
$Administrador=mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $Tel=mysqli_real_escape_string($conn, $_POST['Tel']);
    $Correo=mysqli_real_escape_string($conn, $_POST['Correo']);
    $Contraseña_A=mysqli_real_escape_string($conn, $_POST['Contraseña_A']);

    $_sql="UPDATE administrador SET Tel='$tel', Correo='$Correo', Contraseña_A='$Contraseña_A' WHERW ID_Administrador=$ID_Administrador";
    if (mysqli_query($conn, $sql)){
        echo "Administrador actualizado correctamente. ";

    }else{
        echo"Error:" . mysqli_error($conn);
    }
}

?>
<from method="POST" action="">
    Tel: <input type="text" name="Nombre" value="<?php echo $Administrador['Tel']; ?>"><br>
    Correo: <input type="text" name="Correo" value="<?php echo $Administrador['Correo']; ?>"><br>
    Contraseña: <input type="text" name="Contraseña_A" value="<?php echo $Administrador['Contraseña_A']; ?>"><br>
    <button type="submit">Actualizar</button>
</from>