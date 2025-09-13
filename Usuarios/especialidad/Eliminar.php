<?php 
include("../Conexion.php");

$ID_Especialidad=$GET['ID_Especialidad'];

$sql="DELETE FROM ID_Especialidad WHERE Id_Especialidad=$ID_Especialidad";
if(mysqli_query($conn, $sql)){
    echo "Especialidad eliminado Correctamente.";

}else {
    echo"Error: " . mysqli_error($conn);
}

?>
<a href="listar.php">Volver</a>