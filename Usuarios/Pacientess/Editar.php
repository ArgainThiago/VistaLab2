<?php
include("../Conexion.php");

$Cedula_D = $_GET['Cedula_P'];
$result=mysqli_query($conn, "SELECT * FROM paciente WHERE Cedula_P=$Cedula_P");
$Paciente=mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"]=="POST"){

$Correo= mysqli_real_escape_string($conn, $_POST['Correo']);
$Tel= mysqli_real_escape_string($conn, $_POST['Tel']);
$Contraseña_P=mysqli_real_escape_string($conn, $_POST['Contraseña_P']);
$Fecha_Nac=mysqli_real_escape_string($conn, $_POST['Fecha_Nac']);
$His_med=mysqli_real_escape_string($conn, $_POST['His_med']);
$Sexo=mysqli_real_escape_string($conn, $_POST['Sexo']);
$Nombre_P=mysqli_real_escape_string($conn, $_POST['Nombre_P']);
$Contraseña_P=mysqli_real_escape_string($conn, $_POST['Contraseña_P']);
$Usuario_P=mysqli_real_escape_string($conn, $_POST['Usuario_P']);
    

    $_sql="UPDATE paciente SET Nombre_P='$Nombre_P', Fecha_Nac='$Fecha_Nac', His_Med='$his_Med', Correo='$Correo', Tel='$Tel', Contraseña_P='$Contraseña_P', Sexo='$Sexo',Usuario_P='$Usuario_P' where Cedula_P=$Cedula_P";
    if (mysqli_query($conn, $sql)){
        echo "Paciente actualizado correctamente. ";

    }else{
        echo"Error:" . mysqli_error($conn);
    }
}

?>
<from method="POST" action="">
    Nombre: <input type="text" name="Nombre" value="<?php echo $Paciente['Nombre_P']; ?>"><br>
    Fecha de nacimiento: <input type="date" name="Fecha_de_nacimiento" value="<?php echo $Paciente['Fecha_Nac']; ?>"><br>
    Sexo: <input type="text" name="Sexo" value="<?php echo $Paciente['Sexo']; ?>"><br>
    Correo: <input type="mail" name="correo" value="<?php echo $Paciente['Correo']; ?>"><br>
    Tel: <input type="text" name="Tel" value="<?php echo $Paciente['Tel']; ?>"><br>
    Historial medico: <input type="text" name="His_Med" value="<?php echo $Paciente['His_Med']; ?>"><br>
    Contraseña: <input type="text" name="Contraseña_P" value="<?php echo $Paciente['Contraseña_P']; ?>"><br>
    Usuario: <input type="text" name="Usuario_P" value="<?php echo $Paciente['Usuario_P']; ?>"><br>
    <button type="submit">Actualizar</button>
    <a href="listar.php">Volver</a>
</from>