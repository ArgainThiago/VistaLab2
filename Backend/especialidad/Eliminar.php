<?php 
include("../Conexion.php");

if (isset($_GET['ID_Especialidad']) && is_numeric($_GET['ID_Especialidad'])) {
    $ID_Especialidad = (int) $_GET['ID_Especialidad'];
} else {
    die("ID de especialidad inválido.");
}

$sql = "DELETE FROM especialidad WHERE ID_Especialidad=$ID_Especialidad";

if (mysqli_query($conn, $sql)) {
    echo "Especialidad eliminada correctamente.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<a href="listar.php">Volver</a>
