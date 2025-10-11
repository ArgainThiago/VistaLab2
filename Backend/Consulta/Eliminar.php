<?php 
include("../Conexion.php");

$ID_Consulta=$_GET['ID_Consulta'];

$sql="DELETE FROM consulta WHERE ID_Consulta=$ID_Consulta";
if(mysqli_query($conn, $sql)){
    echo "Consulta eliminada Correctamente.";

}else {
    echo"Error: " . mysqli_error($conn);
}

?>
<a href="listar.php">Volver</a>