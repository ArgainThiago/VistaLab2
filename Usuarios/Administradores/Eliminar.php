<?php 
include("../Conexion.php");

if (isset($_GET['ID_Administrador']) && is_numeric($_GET['ID_Administrador'])) {
    $ID_Administrador = (int) $_GET['ID_Administrador'];
} else {
    die("ID de administrador inválido.");
}

$sql = "DELETE FROM administrador WHERE ID_Administrador=$ID_Administrador";

if(mysqli_query($conn, $sql)){
    echo "Usuario eliminado correctamente.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<a href="listar.php">Volver</a>
