<?php
include("../Conexion.php");

$Cedula_D = $_GET['ID_Especialidad'];
$result=mysqli_query($conn, "SELECT * FROM doctor WHERE ID_Especialidad=$ID_Especialidad");
$Administrador=mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $ID_Especialidad=mysqli_real_escape_string($conn, $_POST['ID_Especialidad']);
    $Nom_Especialidad=mysqli_real_escape_string($conn, $_POST['Nom_Especialidad']);
    $Cedula.D=mysqli_real_escape_string($conn, $_POST['Cedula_D']);
    $Descripcion=mysqli_real_escape_string($conn, $_POST['Descripcion']);
    $Fecha_Esp=mysqli_real_escape_string($conn, $_POST['Fecha_Esp']);
    
    

    $_sql="UPDATE especialidad SET ID_Especialidad='$ID_Especialidad', Nom_Especialidad='$Nom_Especialidad', Cedula_D='$Cedula_D', Descripcion='$Descripcion', Fecha_Esp='$Fecha_Esp' WHERW Cedula_D=$Cedula_D";
    if (mysqli_query($conn, $sql)){
        echo "Especialidad actualizado correctamente. ";

    }else{
        echo"Error:" . mysqli_error($conn);
    }
}

?>
<from method="POST" action="">
    
      ID_Especialidad: <input Type="number" name="ID_Esecialidad"><br>
    Nom_Especialidad: <input Type="text" name="Nom_Esecialidad"><br>
    Cedula_D: <input Type="number" name="Cedula_D"><br>
    Descripcion: <input Type="text" name="Descripcion"><br>
    Fecha_Esp: <input Type="number" name="Fecha_Esp"><br>
    <button type="submit">Actualizar</button>
    <a href="listar.php">Volver</a>
</from>