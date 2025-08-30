<?php 
include("../Conexion.php");

$ID_Administrador=$GET['ID_Administrador'];

$sql="DELETE FROM administrador WHERE ID_Administrador=$ID_Administrador";
if(mysqli_query($conn, $sql)){
    echo "Usuario eliminado Correctamente.";

}else {
    echo"Error: " . mysqli_error($conn);
}

?>
<a href="listar.php">Volver</a>