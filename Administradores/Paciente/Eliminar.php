<?php
include("../../Usuarios/Conexion.php");

if (isset($_GET['Cedula_P']) && is_numeric($_GET['Cedula_P'])) {
    $Cedula_P = (int) $_GET['Cedula_P'];
} else {
    die("Cédula del paciente inválida.");
}

$sql = "DELETE FROM paciente WHERE Cedula_P = $Cedula_P";

if (mysqli_query($conn, $sql)) {
    echo "Paciente eliminado correctamente.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<a href="../PaginaDePacientes.php">Volver</a>
