<?php 
include("../Conexion.php");

$Cedula_D=$GET['Cedula_D'];

$sql="DELETE FROM Cedula_D WHERE Cedula_D=$Cedula_D";
if(mysqli_query($conn, $sql)){
    echo "Doctor eliminado Correctamente.";

}else {
    echo"Error: " . mysqli_error($conn);
}

?>
<a href="listar.php">Volver</a>