<?php
include("../Conexion.php");

$ID_Consulta = $_GET['ID_Consulta'];
$result=mysqli_query($conn, "SELECT * FROM consulta WHERE ID_Consulta=$ID_Consulta");
$Consulta=mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $Cedula_D=mysqli_real_escape_string($conn, $_POST['Cedula_D']);
    $ID_Especialidad=mysqli_real_escape_string($conn, $_POST['ID_Especialidad']);
    $Fecha_Consulta=mysqli_real_escape_string($conn, $_POST['Fecha_Consulta']);
    $Horario=mysqli_real_escape_string($conn, $_POST['Horario']);
    $Cedula_P=mysqli_real_escape_string($conn, $_POST['Cedula_P']);
    $Estado=mysqli_real_escape_string($conn, $_POST['Estado']);

    $sql="UPDATE consulta SET Cedula_D='$Cedula_D', ID_Especialidad='$ID_Especialidad', Fecha_Consulta='$Fecha_Consulta', Horario='$Horario', Cedula_P='$Cedula_P', Estado='$Estado' WHERE ID_Consulta=$ID_Consulta";
    if (mysqli_query($conn, $sql)){
        echo "Consulta actualizada correctamente. ";

    }else{
        echo"Error:" . mysqli_error($conn);
    }
}

?>
<form method="POST" action="">
    Cedula del doctor: <input type="number" name="Cedula_D" value="<?php echo $Consulta['Cedula_D']; ?>"><br>
    Id de la especialidad: <input type="number" name="ID_Especialidad" value="<?php echo $Consulta['ID_Especialidad']; ?>"><br>
    Fecha de la consulta: <input type="date" name="Fecha_Consulta" value="<?php echo $Consulta['Fecha_Consulta']; ?>"><br>
    Horario de la consulta: <input type="time" name="Horario" value="<?php echo $Consulta['Horario']; ?>"><br>
    Cedula del paciente: <input type="number" name="Cedula_P" value="<?php echo $Consulta['Cedula_P']; ?>"><br>
    Estado de la consulta: <input type="enum" name="Estado" value="<?php echo $Consulta['Estado']; ?>"><br>
   
    <button type="submit">Actualizar</button>
</form>