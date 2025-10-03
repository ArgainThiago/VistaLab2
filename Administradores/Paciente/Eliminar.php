<?php
include("../../Usuarios/Conexion.php");

if (isset($_GET['Cedula_P']) && is_numeric($_GET['Cedula_P'])) {
    $Cedula_P = (int) $_GET['Cedula_P'];
} else {
    die("Cédula del paciente inválida.");
}


$sql_consultas = "DELETE FROM consulta WHERE Cedula_P = $Cedula_P";
mysqli_query($conn, $sql_consultas);

$sql_paciente = "DELETE FROM paciente WHERE Cedula_P = $Cedula_P";

if (mysqli_query($conn, $sql_paciente)) {
    echo "<script>
        alert('Paciente eliminado correctamente.');
        window.location.href='../PaginaDePacientes.php';
    </script>";
} else {
    echo "<script>
        alert('Error al eliminar el paciente: " . mysqli_error($conn) . "');
        window.location.href='../PaginaDePacientes.php';
    </script>";
}
?>
