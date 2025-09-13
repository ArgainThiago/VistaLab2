<?php 
include("../Conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

$Nombre_D=mysqli_real_escape_string($conn, $_POST['Nom_Especialidad']);
$Cedula_D= mysqli_real_escape_string($conn, $_POST['Cedula_D']);
$ID_Especialidad=mysqli_real_escape_string($conn, $_POST['ID_Especialidad']);
$Descripcion=mysqli_real_escape_string($conn, $_POST['Descripcion']);
$Fecha_Esp=mysqli_real_escape_string($conn, $_POST['$Fecha_Esp']);



if (¡empty($ID_Especialidad)&& !empty($Nom_Especialidad)&& !empty($Cedula_D)&& !empty($Descripcion)){
    $sql = "INSERT INTO especialidad (ID_Especialidad,Nom_Especialidad, Cedula_D, Descripcion, Fecha_Esp) VALUES ('$ID_Esecialidad', '$Nom_Especialidad', '$Cedula_D','$Fecha_Esp')";
    if(mysqli_query($conn, $sql)){
        echo "Especialidad agregado correctamente.";
    }
    else{
        echo"Error: " . mysqli_error($conn);
    }                       }else{
        echo"Por favor completa todos los campos";
}

}


?>
<from method="POST" action="">
   

    ID_Especialidad: <input Type="number" name="ID_Esecialidad"><br>
    Nom_Especialidad: <input Type="text" name="Nom_Esecialidad"><br>
    Cedula_D: <input Type="number" name="Cedula_D"><br>
    Descripcion: <input Type="text" name="Descripcion"><br>
    Fecha_Esp: <input Type="number" name="Fecha_Esp"><br>
    <button type="submit">Guardar</button>
    <a href="listar.php">Volver</a>

</from>