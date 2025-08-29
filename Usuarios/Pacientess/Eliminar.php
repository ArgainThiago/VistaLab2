<?php 
include("../Conexion.php");

$Cedula_P=$row['Cedula_P'];

$sql="DELETE FROM Cedula_P WHERE Cedula_P=$Cedula_P";
if(mysqli_query($conn, $sql)){
    echo "Paciente eliminado Correctamente.";

}else {
    echo"Error: " . mysqli_error($conn);
}

?>
<a href="listar.php">Volver</a>