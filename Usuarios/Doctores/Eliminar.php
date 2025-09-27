<?php 
include("../Conexion.php");

if (isset($_GET['Cedula_D']) && is_numeric($_GET['Cedula_D'])) {
    $Cedula_D = (int) $_GET['Cedula_D'];
} else {
    die("Cédula del doctor inválida.");
}

$sql = "DELETE FROM doctor WHERE Cedula_D=$Cedula_D";

if (mysqli_query($conn, $sql)) {
    echo "Doctor eliminado correctamente.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<a href="listar.php">Volver</a>
